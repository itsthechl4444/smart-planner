<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\ProjectTask;

class ProjectTaskReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $projectTask;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\ProjectTask $projectTask
     */
    public function __construct(ProjectTask $projectTask)
    {
        $this->projectTask = $projectTask;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database']; // Store in the database
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\DatabaseMessage
     */
    public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'message' => "Reminder: The project task '{$this->projectTask->title}' is due today.",
            'project_task_id' => $this->projectTask->id,
            'project_task_title' => $this->projectTask->title,
            'project_id' => $this->projectTask->project_id,
        ]);
    }
}
