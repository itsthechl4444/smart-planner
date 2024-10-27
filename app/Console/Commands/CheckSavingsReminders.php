<?php

// app/Console/Commands/CheckSavingsReminders.php

namespace App\Console\Commands;

use App\Models\Saving;
use App\Notifications\SavingsReminderNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckSavingsReminders extends Command
{
    protected $signature = 'savings:reminders';
    protected $description = 'Check savings goals and send reminders';

    public function handle()
    {
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');
        $savings = Saving::where('desired_date', $tomorrow)->get();

        foreach ($savings as $saving) {
            if ($saving->user) {
                $saving->user->notify(new SavingsReminderNotification($saving));
            } else {
                $this->warn("Saving ID {$saving->id} does not have an associated user.");
            }
        }

        $this->info('Savings reminders have been sent.');
    }
}
