<?php

namespace App\Tasks;

use SilverStripe\Core\Path;
use SilverStripe\Dev\BuildTask;
use SilverStripe\PolyExecution\PolyOutput;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Bigfork\SilverStripeFailWhale\Model\ErrorDocument;

/**
 * Re-renders the static error pages (assets/error-*.html) when they are missing or reference
 * hashed Vite assets that no longer exist, e.g. after a deploy with a new CSS/JS hash.
 *
 * Run via: php ./vendor/bin/sake tasks:regenerate-error-documents
 */
class RegenerateErrorDocumentsTask extends BuildTask
{
    protected static string $commandName = 'regenerate-error-documents';

    protected string $title = 'Regenerate static error pages';

    protected static string $description = 'Re-renders static error pages if missing or if they reference outdated hashed theme assets. Codes default to "App\Tasks\RegenerateErrorDocumentsTask > default_error_codes".';

    private static array $default_error_codes = [404, 500];

    public function getOptions(): array
    {
        return [
            new InputOption('codes', null, InputOption::VALUE_REQUIRED, 'Comma separated error codes, overrides the configured default_error_codes'),
            new InputOption('force', null, InputOption::VALUE_NONE, 'Regenerate even if the static file looks up to date'),
            new InputOption('dry-run', null, InputOption::VALUE_NONE, 'Only report what would be regenerated'),
        ];
    }

    protected function execute(InputInterface $input, PolyOutput $output): int
    {
        $codes = $this->resolveCodes($input);
        $force = (bool) $input->getOption('force');
        $dryRun = (bool) $input->getOption('dry-run');
        $failed = false;

        foreach ($codes as $code) {
            $document = ErrorDocument::get()->filter('ErrorCode', $code)->first();
            if (!$document) {
                $output->writeln(sprintf('%d: no ErrorDocument record, skipped (run db:build to create defaults)', $code));

                continue;
            }

            $reason = $force ? 'forced' : $this->getStaleReason($code);
            if ($reason === null) {
                $output->writeln(sprintf('%d: up to date', $code));

                continue;
            }

            if ($dryRun) {
                $output->writeln(sprintf('%d: would regenerate (%s)', $code, $reason));

                continue;
            }

            // Unchanged record, so write() ends in ErrorDocument::onAfterSkippedWrite() which rewrites the static file
            $document->write();

            if ($this->getStaleReason($code) !== null) {
                $output->writeln(sprintf('%d: regeneration failed (%s)', $code, $reason));
                $failed = true;

                continue;
            }

            $output->writeln(sprintf('%d: regenerated (%s)', $code, $reason));
        }

        return $failed ? Command::FAILURE : Command::SUCCESS;
    }

    /**
     * @return int[]
     */
    private function resolveCodes(InputInterface $input): array
    {
        $option = $input->getOption('codes');
        $codes = $option !== null && $option !== ''
            ? explode(',', (string) $option)
            : (array) $this->config()->get('default_error_codes');

        return array_values(array_unique(array_filter(array_map('intval', $codes))));
    }

    private function getStaleReason(int $code): ?string
    {
        $content = ErrorDocument::get_content_for_errorcode($code);
        if (empty($content)) {
            return 'static file missing';
        }

        preg_match_all('#/_resources/themes/default/dist/([^"\'\s?\#)]+)#', $content, $matches);
        foreach (array_unique($matches[1]) as $relativePath) {
            if (!is_file(Path::join(BASE_PATH, 'themes', 'default', 'dist', $relativePath))) {
                return 'missing asset ' . $relativePath;
            }
        }

        return null;
    }
}
