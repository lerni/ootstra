<?php

namespace App\Tasks;

use Exception;
use SilverStripe\Dev\BuildTask;
use SilverStripe\Control\Director;
use SilverStripe\Core\Environment;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Email\Email;
use Symfony\Component\Process\Process;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\PolyExecution\PolyOutput;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class ComposerAuditTask extends BuildTask
{
    protected static string $commandName = 'composer-audit';

    protected string $title = 'Composer Audit (Security Advisories & Abandoned Packages)';

    protected static string $description = 'Runs "composer audit" to check for security advisories (CVEs) and abandoned/end-of-life packages, emailing a report if any are found. Use php ./vendor/bin/sake tasks:composer-audit or https://domain.tld/dev/tasks/composer-audit. Options: --to, --dry-run, --include-dev, --abandoned=ignore|report|fail, --ignore-severity=low|medium|high|critical (repeatable).';

    /** Valid values accepted by composer's own `--abandoned` option. */
    private const ABANDONED_MODES = ['ignore', 'report', 'fail'];

    public function getOptions(): array
    {
        return [
            new InputOption('to', null, InputOption::VALUE_REQUIRED, 'Override the recipient email address'),
            new InputOption('dry-run', null, InputOption::VALUE_NONE, 'Build and print the report without sending an email'),
            new InputOption('include-dev', null, InputOption::VALUE_NONE, 'Also audit require-dev packages (default: production only)'),
            new InputOption('abandoned', null, InputOption::VALUE_REQUIRED, 'Behavior for abandoned packages: ignore, report, or fail', 'report'),
            new InputOption('ignore-severity', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Advisory severity to ignore: low, medium, high, or critical (repeatable)'),
        ];
    }

    protected function execute(InputInterface $input, PolyOutput $output): int
    {
        $composerBin = $this->resolveComposerBinary();

        if ($composerBin === null) {
            $output->writeln('Error: Could not find a composer executable (checked "which composer" and ~/bin/composer.phar).');

            return Command::FAILURE;
        }

        if (Director::is_cli()) {
            $dryRun = (bool) $input->getOption('dry-run');
            $includeDev = (bool) $input->getOption('include-dev');
            $abandonedMode = (string) $input->getOption('abandoned');
            $ignoreSeverities = (array) $input->getOption('ignore-severity');
            $to = $input->getOption('to');
        } else {
            $request = Controller::curr()->getRequest();
            $dryRun = (bool) $request->getVar('dry-run');
            $includeDev = (bool) $request->getVar('include-dev');
            $abandonedMode = $request->getVar('abandoned') ?: 'report';
            $ignoreSeverities = (array) ($request->getVar('ignore-severity') ?: []);
            $to = $request->getVar('to');
        }

        if (!in_array($abandonedMode, self::ABANDONED_MODES, true)) {
            $abandonedMode = 'report';
        }

        $args = array_merge($composerBin, ['audit', '--format=json', '--no-interaction']);

        if (!$includeDev) {
            $args[] = '--no-dev';
        }

        $args[] = '--abandoned=' . $abandonedMode;

        foreach ($ignoreSeverities as $severity) {
            $severity = trim((string) $severity);

            if ($severity !== '') {
                $args[] = '--ignore-severity=' . $severity;
            }
        }

        $process = new Process($args, BASE_PATH);
        $process->setTimeout(120);
        $process->run();

        // composer audit exits 1 merely because it found something to report, not because it failed to run
        $data = json_decode($process->getOutput(), true);

        if (!is_array($data)) {
            $output->writeln('Error: Could not parse "composer audit" output.');
            $output->writeln($process->getErrorOutput());

            return Command::FAILURE;
        }

        $advisories = $data['advisories'] ?? [];
        $abandoned = $data['abandoned'] ?? [];
        $advisoryCount = array_sum(array_map('count', $advisories));
        $abandonedCount = count($abandoned);

        if ($advisoryCount === 0 && $abandonedCount === 0) {
            $output->writeln('No security advisories or abandoned packages found.');

            return Command::SUCCESS;
        }

        $domain = Director::absoluteBaseURL();
        $body = $this->buildReportBody($domain, DBDatetime::now()->Nice(), $advisories, $abandoned);

        $output->writeln("Found {$advisoryCount} advisory/advisories and {$abandonedCount} abandoned package(s).");

        if ($dryRun) {
            $output->writeln('Dry run, not sending email:');
            $output->writeln($body);

            return Command::SUCCESS;
        }

        if (!$to || !Email::is_valid_address($to)) {
            $to = Environment::getEnv('SS_ERROR_EMAIL');
        }

        if (!$to || !Email::is_valid_address($to)) {
            $adminEmail = Email::config()->get('admin_email');

            if (is_array($adminEmail) && $adminEmail !== []) {
                $to = key($adminEmail);
            } elseif (is_string($adminEmail) && Email::is_valid_address($adminEmail)) {
                $to = $adminEmail;
            } else {
                $output->writeln('Error: No valid recipient email address specified. Configure SS_ERROR_EMAIL or admin_email.');

                return Command::FAILURE;
            }
        }

        $email = Email::create()
            ->setBody($body)
            ->setTo($to)
            ->setSubject("Composer Audit: {$advisoryCount} advisories, {$abandonedCount} abandoned packages on {$domain}");

        try {
            $email->send();
            $output->writeln("Report emailed to {$to}.");

            return Command::SUCCESS;
        } catch (TransportExceptionInterface $e) {
            $output->writeln('Failed to send report email. Reason: ' . $e->getMessage());

            return Command::FAILURE;
        } catch (Exception $e) {
            $output->writeln('Failed to send report email. An error occurred: ' . $e->getMessage());

            return Command::FAILURE;
        }
    }

    /**
     * @return string[]|null Base command to prepend composer arguments to, or null if composer could not be located.
     */
    private function resolveComposerBinary(): ?array
    {
        $which = new Process(['which', 'composer']);
        $which->run();
        $lines = explode("\n", trim($which->getOutput()));
        $path = $lines[0] ?? '';

        if ($path !== '' && is_executable($path)) {
            return [$path];
        }

        $home = Environment::getEnv('HOME') ?: getenv('HOME');

        if ($home) {
            $phar = rtrim($home, '/') . '/bin/composer.phar';

            if (is_file($phar)) {
                return [PHP_BINARY, $phar];
            }
        }

        return null;
    }

    private function buildReportBody(string $domain, string $checkedAt, array $advisories, array $abandoned): string
    {
        $lines = [
            "Composer audit report for {$domain}.",
            "Checked at: {$checkedAt}<br>",
        ];

        if ($advisories !== []) {
            $lines[] = '<br><strong>Security advisories:</strong><br>';

            foreach ($advisories as $package => $packageAdvisories) {
                foreach ($packageAdvisories as $advisory) {
                    $cve = $advisory['cve'] ?? null;
                    $severity = $advisory['severity'] ?? 'unknown';
                    $title = $advisory['title'] ?? 'Untitled advisory';
                    $link = $advisory['link'] ?? null;

                    $line = "- {$package} [{$severity}]" . ($cve ? " ({$cve})" : '') . ": {$title}";

                    if ($link) {
                        $line .= " ({$link})";
                    }

                    $lines[] = $line . '<br>';
                }
            }
        }

        if ($abandoned !== []) {
            $lines[] = '<br><strong>Abandoned packages:</strong><br>';

            foreach ($abandoned as $package => $replacement) {
                $replacementText = is_string($replacement) ? "replaced by {$replacement}" : 'no replacement suggested';
                $lines[] = "- {$package}: {$replacementText}<br>";
            }
        }

        return implode("\n", $lines);
    }
}
