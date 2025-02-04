<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailerService
{
    protected $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);

        // Server settings
        $this->mailer->isSMTP();
        $this->mailer->Host       = config('mail.host');
        $this->mailer->SMTPAuth   = true;
        $this->mailer->Username   = config('mail.username');
        $this->mailer->Password   = config('mail.password');
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port       = config('mail.port');

        // Sender info
        $this->mailer->setFrom(config('mail.from.address'), config('mail.from.name'));
    }

    /**
     * Send an email using PHPMailer.
     *
     * @param string $to
     * @param string $toName
     * @param string $subject
     * @param string $body
     * @param string $altBody
     * @return void
     */
    public function sendMail($to, $toName, $subject, $body, $altBody = '')
    {
        try {
            // Clear previous recipients
            $this->mailer->clearAddresses();

            // Add recipient
            $this->mailer->addAddress($to, $toName);

            // Content
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body    = $body;
            $this->mailer->AltBody = $altBody;

            // Send the email
            $this->mailer->send();
        } catch (Exception $e) {
            // Log the error message
            \Log::error("PHPMailer Error: {$this->mailer->ErrorInfo}");
        }
    }
}
