<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class CustomResetPasswordNotification extends Notification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['phpmailer', 'database']; // Use 'phpmailer' instead of 'mail'
    }

    /**
     * Define how the notification should be sent via PHPMailer.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toPHPMailer($notifiable)
    {
        // Generate the reset URL
        $resetUrl = $this->resetUrl($notifiable);

        return [
            'to'      => $notifiable->email,
            'toName'  => $notifiable->name,
            'subject' => 'Reset Your Password',
            'body'    => "
                <div style='text-align: center; margin-bottom: 20px;'>
                    <img src='" . asset('images/logo.png') . "' alt='Smart Planner Logo' width='150'>
                </div>
                <h1>Reset Your Password</h1>
                <p>Hello {$notifiable->name},</p>
                <p>You are receiving this email because we received a password reset request for your account.</p>
                <p><a href='{$resetUrl}'>Reset Password</a></p>
                <p>This password reset link will expire in " . config('auth.passwords.' . config('auth.defaults.passwords') . '.expire') . " minutes.</p>
                <p>If you did not request a password reset, no further action is required.</p>
                <p>Regards, Smart Planner</p>
            ",
            'altBody' => "Hello {$notifiable->name},\n\nYou are receiving this email because we received a password reset request for your account.\n\nReset Password: {$resetUrl}\n\nThis password reset link will expire in " . config('auth.passwords.' . config('auth.defaults.passwords') . '.expire') . " minutes.\n\nIf you did not request a password reset, no further action is required.\n\nRegards, Smart Planner"
        ];
    }

    /**
     * Get the reset URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function resetUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'password.reset',
            Carbon::now()->addMinutes(config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')),
            ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()]
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
            'message' => 'A password reset was requested for your account.',
        ];
    }
}
