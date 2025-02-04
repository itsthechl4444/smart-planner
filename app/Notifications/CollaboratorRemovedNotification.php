<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CollaboratorRemovedNotification extends Notification
{
    use Queueable;

    protected $project;
    protected $removedBy;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Project $project
     * @param \App\Models\User    $removedBy
     * @return void
     */
    public function __construct($project, $removedBy)
    {
        $this->project = $project;
        $this->removedBy = $removedBy;
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
        return [
            'to'      => $notifiable->email,
            'toName'  => $notifiable->name,
            'subject' => "You have been removed from '{$this->project->name}'",
            'body'    => "
                <h1>Collaborator Removed</h1>
                <p>Hello {$notifiable->name},</p>
                <p>You have been removed from the project '{$this->project->name}' by {$this->removedBy->name}.</p>
                <p>If this was a mistake, please contact support.</p>
            ",
            'altBody' => "Hello {$notifiable->name},\n\nYou have been removed from the project '{$this->project->name}' by {$this->removedBy->name}.\n\nIf this was a mistake, please contact support.",
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
            'message'               => "You have been removed from '{$this->project->name}' by {$this->removedBy->name}.",
            'project_id'            => $this->project->id,
            'project_name'          => $this->project->name,
            'removed_by_name'      => $this->removedBy->name,
        ];
    }
}
