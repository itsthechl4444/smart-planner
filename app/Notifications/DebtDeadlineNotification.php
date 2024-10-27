<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Debt;

class DebtDeadlineNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $debt;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Debt $debt
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
            'title' => 'Debt Deadline',
            'message' => "Reminder: Your debt '{$this->debt->name}' is due tomorrow.",
            'debt_id' => $this->debt->id,
            'debt_name' => $this->debt->name,
            'due_date' => $this->debt->due_date->toDateString(),
        ]);
    }
    
}
