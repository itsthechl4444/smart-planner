<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class CustomVerifyEmail extends Notification
{
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['phpmailer', 'database']; // Ensure 'phpmailer' is correctly set up
    }

    /**
     * Define how the notification should be sent via PHPMailer.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toPHPMailer($notifiable)
    {
        // Generate the verification URL
        $verificationUrl = $this->verificationUrl($notifiable);

        return [
            'to'      => $notifiable->email,
            'toName'  => $notifiable->name,
            'subject' => 'Verify Your Email Address',
            'body'    => "
                <h1>Verify Your Email Address</h1>
                <p>Hello {$notifiable->name},</p>
                <p>Please click the button below to verify your email address.</p>
                <p><a href='{$verificationUrl}' style='display: inline-block; padding: 10px 20px; background-color: #666; color: white; text-decoration: none; border-radius: 5px;'>Verify Email</a></p>
                <p>If you did not create an account, no further action is required.</p>
                <p>Regards, Smart Planner</p>
            ",
            'altBody' => "Hello {$notifiable->name},\n\nPlease verify your email address by visiting the following link:\n\n{$verificationUrl}\n\nIf you did not create an account, no further action is required.\n\nRegards, Smart Planner"
        ];
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60), // Adjust expiration as needed
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        );
    }

    /**
     * Get the array representation of the notification for database storage.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Please verify your email address to complete your registration.',
        ];
    }
}
