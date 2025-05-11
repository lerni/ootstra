<?php

namespace App\Tasks;

use SilverStripe\ORM\DB;
use SilverStripe\Dev\BuildTask;
use SilverStripe\Control\Director;
use SilverStripe\Control\Email\Email;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\FieldType\DBDatetime;

class TestEmailTask extends BuildTask {

    protected $title = 'Send Test Email';

    protected $description = "Sends a test email. Use ?to=recipient@example.com to specify the recipient.";

    private static $segment = 'test-email-task';

    public function run($request) {

        $domain = Director::absoluteBaseURL();
        $ipAddress = $request->getIP();
        $forwardedFor = $request->getHeader('X-Forwarded-For');
        $now = DBDatetime::now();
        $sentTime = $now->Nice();

        $to = $request->getVar('to');

        if (!$to || !Email::is_valid_address($to)) {
            $adminEmail = Email::config()->get('admin_email');
            if (is_array($adminEmail) && count($adminEmail) > 0) {
                $to = key($adminEmail);
            } elseif (is_string($adminEmail) && Email::is_valid_address($adminEmail)) {
                $to = $adminEmail;
            } else {
                DB::alteration_message("Error: No valid recipient email address specified. Use ?to=recipient@example.com or configure an admin_email in your Email config.", "error");
                return;
            }
            DB::alteration_message("Recipient email not provided or invalid. Falling back to '{$to}'.");
        }

        DB::alteration_message("Sending test email to {$to}...");

        $bodyContent = "Test email from {$domain}. <br>";
        $bodyContent .= "Sent at: {$sentTime}<br>";
        $bodyContent .= "Triggered by IP: {$ipAddress}<br>";
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
            DB::alteration_message("Sent successfully!", "created");
        } catch (\Symfony\Component\Mailer\Exception\TransportExceptionInterface $e) {
            DB::alteration_message("Failed. Email not sent. Reason: " . $e->getMessage(), "error");
        } catch (\Exception $e) {
            DB::alteration_message("Failed. Email not sent. An error occurred: " . $e->getMessage(), "error");
        }
    }
}
