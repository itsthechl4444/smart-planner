<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Project;
use App\Models\User;

class ProjectInvitationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $project;
    protected $inviter;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Project $project
     * @param \App\Models\User $inviter
     */
    public function __construct(Project $project, User $inviter)
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
        return ['database']; // In-app notification
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => "{$this->inviter->name} has invited you to collaborate on the project '{$this->project->name}'.",
            'project_id' => $this->project->id,
            'project_name' => $this->project->name,
            'inviter_id' => $this->inviter->id,
            'inviter_name' => $this->inviter->name,
        ];
    }
}
