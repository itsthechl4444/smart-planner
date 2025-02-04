<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
// Remove the built-in mail channel
// use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class ProjectInvitationNotification extends Notification
{
    use Queueable;

    protected $project;
    protected $inviter;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Project $project
     * @param \App\Models\User    $inviter
     * @return void
     */
    public function __construct($project, $inviter)
    {
        $this->project = $project;
        $this->inviter = $inviter;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['phpmailer', 'database'];
    }

    /**
     * Get the PHPMailer representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toPHPMailer($notifiable)
    {
        $acceptUrl = route('collaborations.accept', ['project' => $this->project->id, 'user' => $notifiable->id]);
        $declineUrl = route('collaborations.decline', ['project' => $this->project->id, 'user' => $notifiable->id]);

        return [
            'to'      => $notifiable->email,
            'toName'  => $notifiable->name,
            'subject' => "Invitation to Collaborate on '{$this->project->name}'",
            'body'    => "
                <h1>Project Invitation</h1>
                <p>Hello {$notifiable->name},</p>
                <p>{$this->inviter->name} has invited you to collaborate on the project '{$this->project->name}'.</p>
                <p>
                    <a href='{$acceptUrl}' style='padding: 10px 15px; background-color: #28a745; color: #fff; text-decoration: none; border-radius: 5px;'>Accept Invitation</a>
                    &nbsp;
                    <a href='{$declineUrl}' style='padding: 10px 15px; background-color: #dc3545; color: #fff; text-decoration: none; border-radius: 5px;'>Decline Invitation</a>
                </p>
                <p>We look forward to your collaboration!</p>
            ",
            'altBody' => "Hello {$notifiable->name},\n\n{$this->inviter->name} has invited you to collaborate on the project '{$this->project->name}'.\n\nAccept Invitation: {$acceptUrl}\nDecline Invitation: {$declineUrl}\n\nWe look forward to your collaboration!",
        ];
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
            'message'      => "{$this->inviter->name} has invited you to collaborate on '{$this->project->name}'.",
            'project_id'   => $this->project->id,
            'project_name' => $this->project->name,
            'inviter_name' => $this->inviter->name,
        ];
    }
}
