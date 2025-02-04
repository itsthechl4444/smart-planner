<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use App\Services\PHPMailerService;

class CustomChannel
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
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        if (method_exists($notification, 'toCustom')) {
            $notification->toCustom($notifiable);
        }
    }
}
