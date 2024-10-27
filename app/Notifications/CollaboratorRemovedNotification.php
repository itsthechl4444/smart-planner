<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue; // Optional: Implement if you want to queue notifications
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Project;
use App\Models\User;

class CollaboratorRemovedNotification extends Notification
{
    use Queueable;

    protected $project;
    protected $removedBy;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Project $project
     * @param \App\Models\User $removedBy
     * @return void
     */
    public function __construct(Project $project, User $removedBy)
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
        return ['mail', 'database']; // You can add other channels like 'broadcast' if needed
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('You Have Been Removed from a Project')
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line('You have been removed from the project "' . $this->project->name . '".')
                    ->line('Removed By: ' . $this->removedBy->name)
                    ->action('View Project', route('projects.show', $this->project))
                    ->line('If you believe this was a mistake, please contact the project owner.');
    }

    /**
     * Get the array representation of the notification for database storage.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'You have been removed from the project "' . $this->project->name . '" by ' . $this->removedBy->name . '.',
            'project_id' => $this->project->id,
            'removed_by_id' => $this->removedBy->id,
            'removed_by_name' => $this->removedBy->name,
        ];
    }
}
