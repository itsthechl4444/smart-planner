<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProjectInvitationResponseNotification extends Notification
{
    use Queueable;

    protected $project;
    protected $collaborator;
    protected $response; // 'accepted' or 'declined'

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Project $project
     * @param \App\Models\User    $collaborator
     * @param string              $response
     * @return void
     */
    public function __construct($project, $collaborator, $response)
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
        $status = ucfirst($this->response); // 'Accepted' or 'Declined'

        return [
            'to'      => $notifiable->email,
            'toName'  => $notifiable->name,
            'subject' => "Your Invitation to '{$this->project->name}' has been {$this->response}",
            'body'    => "
                <h1>Invitation Response</h1>
                <p>Hello {$notifiable->name},</p>
                <p>{$this->collaborator->name} has {$this->response} your invitation to collaborate on the project '{$this->project->name}'.</p>
                <p><a href='" . route('projects.show', $this->project->id) . "' style='padding: 10px 15px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px;'>View Project</a></p>
            ",
            'altBody' => "Hello {$notifiable->name},\n\n{$this->collaborator->name} has {$this->response} your invitation to collaborate on the project '{$this->project->name}'.\n\nView Project: " . route('projects.show', $this->project->id),
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
            'message'               => "{$this->collaborator->name} has {$this->response} your invitation to collaborate on '{$this->project->name}'.",
            'project_id'            => $this->project->id,
            'project_name'          => $this->project->name,
            'collaborator_name'     => $this->collaborator->name,
            'response'              => $this->response,
        ];
    }
}
