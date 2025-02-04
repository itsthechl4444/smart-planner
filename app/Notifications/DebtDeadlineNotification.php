<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Debt;

class DebtDeadlineNotification extends Notification
{
    use Queueable;

    protected $debt;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Debt $debt
     * @return void
     */
    public function __construct(Debt $debt)
    {
        $this->debt = $debt;
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
     * Define how the notification should be sent via PHPMailer.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toPHPMailer($notifiable)
    {
        $dueDateFormatted = $this->debt->due_date->format('F j, Y'); // e.g., January 1, 2024

        $viewDebtUrl = route('debts.show', ['debt' => $this->debt->id]);

        return [
            'to'      => $notifiable->email,
            'toName'  => $notifiable->name,
            'subject' => "Debt Deadline Reminder: '{$this->debt->name}' is due today",
            'body'    => "
                <h1>Debt Deadline Reminder</h1>
                <p>Hi {$notifiable->name},</p>
                <p>This is a reminder that your debt '<strong>{$this->debt->name}</strong>' is due today, <strong>{$dueDateFormatted}</strong>.</p>
                <p><a href='{$viewDebtUrl}' style='padding: 10px 15px; background-color: #28a745; color: #fff; text-decoration: none; border-radius: 5px;'>View Debt</a></p>
            ",
            'altBody' => "Hi {$notifiable->name},\n\nThis is a reminder that your debt '{$this->debt->name}' is due today, {$dueDateFormatted}.\n\nView Debt: {$viewDebtUrl}",
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
            'message'    => "Reminder: Your debt '{$this->debt->name}' is due today ({$this->debt->due_date->toDateString()}).",
            'debt_id'    => $this->debt->id,
            'debt_name'  => $this->debt->name,
            'due_date'   => $this->debt->due_date->toDateString(),
            'amount'     => $this->debt->amount,
            'currency'   => $this->debt->currency,
            'type'       => $this->debt->type,
            'view_url'   => route('debts.show', ['debt' => $this->debt->id]),
        ];
    }
}
