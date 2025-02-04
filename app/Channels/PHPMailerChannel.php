<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use App\Services\PHPMailerService;

class PHPMailerChannel
{
    protected $mailer;

    /**
     * Create a new channel instance.
     *
     * @param PHPMailerService $mailer
     * @return void
     */
    public function __construct(PHPMailerService $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        // Check if the notification has a toPHPMailer method
        if (!method_exists($notification, 'toPHPMailer')) {
            return;
        }

        // Get the email data from the notification
        $message = $notification->toPHPMailer($notifiable);

        // Ensure message has required fields
        if (!$message || !isset($message['to'], $message['toName'], $message['subject'], $message['body'])) {
            return;
        }

        // Send the email using PHPMailerService
        $this->mailer->sendMail(
            $message['to'],
            $message['toName'],
            $message['subject'],
            $message['body'],
            $message['altBody'] ?? ''
        );
    }
}
