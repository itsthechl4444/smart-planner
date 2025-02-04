<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class TaskReminderNotification extends Notification
{
    protected $task;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
        Log::info("TaskReminderNotification: Initialized for task ID {$this->task->id}.");
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        Log::info("TaskReminderNotification: via() called for notifiable ID {$notifiable->id}.");
        return ['phpmailer', 'database'];
    }

    /**
     * Define the email data to be sent via PHPMailer.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toPHPMailer($notifiable)
    {
        Log::info("TaskReminderNotification: Preparing PHPMailer data for {$notifiable->email}.");

        $subject = 'Task Reminder';
        $body = "
            <h1>Task Reminder</h1>
            <p>Hi {$notifiable->name},</p>
            <p>Reminder: The task '<strong>{$this->task->title}</strong>' is due today.</p>
            <p><a href='" . route('tasks.show', $this->task->id) . "'>View Task</a></p>
        ";
        $altBody = "Hi {$notifiable->name},\n\nReminder: The task '{$this->task->title}' is due today.\n\nView Task: " . route('tasks.show', $this->task->id);

        Log::info("TaskReminderNotification: PHPMailer data prepared for {$notifiable->email}.");

        return [
            'to'      => $notifiable->email,
            'toName'  => $notifiable->name,
            'subject' => $subject,
            'body'    => $body,
            'altBody' => $altBody,
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
        Log::info("TaskReminderNotification: Preparing database data for notifiable ID {$notifiable->id}.");

        return [
            'message'    => "Reminder: The task '{$this->task->title}' is due today.",
            'task_id'    => $this->task->id,
            'task_title' => $this->task->title,
        ];
    }
}
