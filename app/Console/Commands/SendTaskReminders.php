<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Notifications\TaskReminder;
use Carbon\Carbon;

class SendTaskReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for tasks due today with reminders set';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        // Fetch tasks due today with reminder set
        $tasks = Task::whereDate('due_date', $today)
                    ->where('reminder', true)
                    ->with('user') // Assuming Task belongs to User
                    ->get();

        foreach ($tasks as $task) {
            // Dispatch the TaskReminder notification
            $task->user->notify(new TaskReminder($task));
        }

        $this->info('Task reminders sent successfully.');
    }
}
