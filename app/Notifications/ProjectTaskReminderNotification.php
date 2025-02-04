<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Models\ProjectTask;
use Illuminate\Support\Facades\Log;

class ProjectTaskReminderNotification extends Notification
{
    protected $projectTask;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\ProjectTask $projectTask
     */
    public function __construct(ProjectTask $projectTask)
    {
        $this->projectTask = $projectTask;
        Log::info("ProjectTaskReminderNotification: Initialized for task ID {$this->projectTask->id}.");
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        Log::info("ProjectTaskReminderNotification: via() called for notifiable ID {$notifiable->id}.");
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
        Log::info("ProjectTaskReminderNotification: Preparing PHPMailer data for {$notifiable->email}.");

        $subject = 'Project Task Reminder';
        $body = "
            <h1>Project Task Reminder</h1>
            <p>Hi {$notifiable->name},</p>
            <p>Reminder: The project task '<strong>{$this->projectTask->title}</strong>' is due today.</p>
            <p><a href='" . route('projecttasks.show', $this->projectTask->id) . "'>View Project Task</a></p>
        ";
        $altBody = "Hi {$notifiable->name},\n\nReminder: The project task '{$this->projectTask->title}' is due today.\n\nView Project Task: " . route('projecttasks.show', $this->projectTask->id);

        Log::info("ProjectTaskReminderNotification: PHPMailer data prepared for {$notifiable->email}.");

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
        Log::info("ProjectTaskReminderNotification: Preparing database data for notifiable ID {$notifiable->id}.");

        return [
            'message'             => "Reminder: The project task '{$this->projectTask->title}' is due today.",
            'project_task_id'     => $this->projectTask->id,
            'project_task_title'  => $this->projectTask->title,
        ];
    }
}
