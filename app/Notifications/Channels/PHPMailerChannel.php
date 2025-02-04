<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailerChannel
{
    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toPHPMailer')) {
            return;
        }

        $mailData = $notification->toPHPMailer($notifiable);

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = config('mail.mailers.smtp.host', 'smtp.gmail.com');
            $mail->SMTPAuth   = true;
            $mail->Username   = config('mail.mailers.smtp.username');
            $mail->Password   = config('mail.mailers.smtp.password');
            $mail->SMTPSecure = config('mail.mailers.smtp.encryption', PHPMailer::ENCRYPTION_STARTTLS);
            $mail->Port       = config('mail.mailers.smtp.port', 587);

            // Recipients
            $mail->setFrom(config('mail.from.address'), config('mail.from.name'));
            $mail->addAddress($mailData['to'], $mailData['toName']);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $mailData['subject'];
            $mail->Body    = $mailData['body'];
            $mail->AltBody = $mailData['altBody'];

            // Send the email
            $mail->send();

            // Optionally, log successful send
            \Log::info("PHPMailerChannel: Email sent successfully to {$mailData['to']}");
        } catch (Exception $e) {
            // Log PHPMailer errors
            \Log::error("PHPMailerChannel: Email could not be sent to {$mailData['to']}. Error: {$mail->ErrorInfo}");
        }
    }
}
