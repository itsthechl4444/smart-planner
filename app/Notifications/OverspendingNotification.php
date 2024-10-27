<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Budget;

class OverspendingNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $budget;
    protected $totalExpenses;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Budget $budget
     * @param float $totalExpenses
     */
    public function __construct(Budget $budget, float $totalExpenses)
    {
        $this->budget = $budget;
        $this->totalExpenses = $totalExpenses;
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
            'message' => "Alert: You've exceeded your budget of \$" . number_format($this->budget->amount, 2) . " with total expenses of \$" . number_format($this->totalExpenses, 2) . ".",
            'budget_id' => $this->budget->id,
            'budget_amount' => $this->budget->amount,
            'total_expenses' => $this->totalExpenses,
        ]);
    }
}
