<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Budget;
use Illuminate\Support\Facades\Log;

class OverspendingNotification extends Notification
{
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
        Log::info("OverspendingNotification: Initialized for budget ID {$this->budget->id}.");
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        Log::info("OverspendingNotification: via() called for notifiable ID {$notifiable->id}.");
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
        Log::info("OverspendingNotification: Preparing PHPMailer data for {$notifiable->email}.");

        $subject = "Overspending Alert: You've Exceeded Your Budget";
        $body = "
            <h1>Overspending Alert</h1>
            <p>Hi {$notifiable->name},</p>
            <p>Alert: You've exceeded your budget of \$" . number_format($this->budget->amount, 2) . " with total expenses of \$" . number_format($this->totalExpenses, 2) . ".</p>
            <p><a href='" . route('budgets.show', $this->budget->id) . "'>View Budget</a></p>
        ";
        $altBody = "Hi {$notifiable->name},\n\nAlert: You've exceeded your budget of \$" . number_format($this->budget->amount, 2) . " with total expenses of \$" . number_format($this->totalExpenses, 2) . ".\n\nView Budget: " . route('budgets.show', $this->budget->id);

        Log::info("OverspendingNotification: PHPMailer data prepared for {$notifiable->email}.");

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
        Log::info("OverspendingNotification: Preparing database data for notifiable ID {$notifiable->id}.");

        return [
            'message'         => "Alert: You've exceeded your budget of \$" . number_format($this->budget->amount, 2) . " with total expenses of \$" . number_format($this->totalExpenses, 2) . ".",
            'budget_id'       => $this->budget->id,
            'budget_amount'   => $this->budget->amount,
            'total_expenses'  => $this->totalExpenses,
            'view_url'        => route('budgets.show', ['budget' => $this->budget->id]),
        ];
    }
}
