<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Debt;
use App\Notifications\DebtDeadlineNotification;
use Carbon\Carbon;

class SendDebtReminders extends Command
{
    protected $signature = 'debts:send-reminders';
    protected $description = 'Send debt deadline reminders for debts due today and tomorrow';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        // Fetch debts due today with reminder set
        $debtsToday = Debt::whereDate('due_date', $today)
            ->where('reminder', true)
            ->get();

        foreach ($debtsToday as $debt) {
            $debt->user->notify(new DebtDeadlineNotification($debt));
        }

        // Fetch debts due tomorrow with reminder set
        $debtsTomorrow = Debt::whereDate('due_date', $tomorrow)
            ->where('reminder', true)
            ->get();

        foreach ($debtsTomorrow as $debt) {
            $debt->user->notify(new DebtDeadlineNotification($debt));
        }

        $this->info('Debt deadline reminders sent successfully for today and tomorrow.');
    }
}
