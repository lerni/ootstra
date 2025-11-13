<?php

namespace App\Tasks;

use Exception;
use SilverStripe\Dev\BuildTask;
use SilverStripe\Control\Director;
use SilverStripe\Control\Email\Email;
use SilverStripe\Control\Controller;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\PolyExecution\PolyOutput;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class TestEmailTask extends BuildTask {

    protected string $title = 'Send Test Email';

    protected static string $description = "Sends a test email. CLI: Use --to=recipient@example.com. HTTP: Use ?to=recipient@example.com to specify the recipient.";

    private static $segment = 'test-email-task';

    public function getOptions(): array
    {
        return [
            new InputOption('to', null, InputOption::VALUE_REQUIRED, 'Email address to send the test email to'),
        ];
    }

    protected function execute(InputInterface $input, PolyOutput $output): int {

        $domain = Director::absoluteBaseURL();
        $now = DBDatetime::now();
        $sentTime = $now->Nice();

        // Determine execution context and get appropriate information
        $isCli = Director::is_cli();
        if ($isCli) {
            // CLI execution
            $ipAddress = 'CLI execution';
            $forwardedFor = null;
        } else {
            // HTTP execution - get request data
            $controller = Controller::curr();
            if ($controller instanceof Controller) {
                $request = $controller->getRequest();
                $ipAddress = $request->getIP();
                $forwardedFor = $request->getHeader('X-Forwarded-For');
            } else {
                $ipAddress = 'HTTP execution (IP unknown)';
                $forwardedFor = null;
            }
        }

        // Get the 'to' parameter - different handling for CLI vs HTTP
        if ($isCli) {
            $to = $input->getOption('to');
        } else {
            // For HTTP execution, get from request parameters
            $controller = Controller::curr();
            $request = $controller instanceof Controller ? $controller->getRequest() : null;
            $to = $request ? $request->getVar('to') : null;
        }

        if (!$to || !Email::is_valid_address($to)) {
            $adminEmail = Email::config()->get('admin_email');
            if (is_array($adminEmail) && count($adminEmail) > 0) {
                $to = key($adminEmail);
            } elseif (is_string($adminEmail) && Email::is_valid_address($adminEmail)) {
                $to = $adminEmail;
            } else {
                $output->writeln("Error: No valid recipient email address specified. Configure an admin_email in your Email config.");
                return Command::FAILURE;
            }
            $output->writeln("Using configured admin email: {$to}");
        }

        $output->writeln("Sending test email to {$to}...");

        $bodyContent = "Test email from {$domain}. <br>";
        $bodyContent .= "Sent at: {$sentTime}<br>";
        $bodyContent .= "Execution context: " . ($isCli ? 'CLI' : 'HTTP') . "<br>";
        $bodyContent .= "Triggered by: {$ipAddress}<br>";
        // Add X-Forwarded-For if it exists
        if ($forwardedFor) {
            $bodyContent .= "X-Forwarded-For: {$forwardedFor}<br>";
        }

        $email = Email::create()
            ->setBody($bodyContent)
            ->setTo($to)
            ->setSubject("Test: {$domain}");

        try {
            $email->send();
            $output->writeln("Sent successfully!");
            return Command::SUCCESS;
        } catch (TransportExceptionInterface $e) {
            $output->writeln("Failed. Email not sent. Reason: " . $e->getMessage());
            return Command::FAILURE;
        } catch (Exception $e) {
            $output->writeln("Failed. Email not sent. An error occurred: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
