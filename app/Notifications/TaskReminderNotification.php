<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Task;

class TaskReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database']; // Storing in database
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
            'message' => "Reminder: The task '{$this->task->title}' is due today.",
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
        ]);
    }
}
