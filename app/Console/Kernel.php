<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Task;
use App\Notifications\TaskReminderNotification;



class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Schedule the task reminders to run daily at 8 AM
        $schedule->command('tasks:send-reminders')->dailyAt('08:00');
        $schedule->command('debts:send-reminders')->dailyAt('08:00');
    }
    



    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }


}
