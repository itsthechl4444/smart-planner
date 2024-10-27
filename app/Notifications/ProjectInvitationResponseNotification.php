<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Project;
use App\Models\User;

class ProjectInvitationResponseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $project;
    protected $collaborator;
    protected $response; // 'accepted' or 'declined'

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Project $project
     * @param \App\Models\User $collaborator
     * @param string $response
     */
    public function __construct(Project $project, User $collaborator, string $response)
    {
        $this->project = $project;
        $this->collaborator = $collaborator;
        $this->response = $response;
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
        $statusMessage = ucfirst($this->response);
        return [
            'message' => "{$this->collaborator->name} has {$this->response} your invitation to collaborate on the project '{$this->project->name}'.",
            'project_id' => $this->project->id,
            'project_name' => $this->project->name,
            'collaborator_id' => $this->collaborator->id,
            'collaborator_name' => $this->collaborator->name,
            'response' => $this->response,
        ];
    }
}
