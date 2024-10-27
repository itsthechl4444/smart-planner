<?php

namespace App\Jobs;

use App\Models\Savings;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CheckSavingsReminders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        // Get tomorrow's date
        $tomorrow = Carbon::tomorrow();

        // Fetch all savings where the desired_date is tomorrow
        $savings = Savings::where('desired_date', $tomorrow)->get();

        foreach ($savings as $saving) {
            // Assuming you have a 'user_id' field in your 'savings' table linking to users
            $user = $saving->user;

            // Create a notification for the user
            Notification::create([
                'user_id' => $user->id,
                'title' => 'Savings Goal Reminder',
                'message' => "Your savings goal '{$saving->name}' with an amount of {$saving->desired_amount} is due tomorrow!",
            ]);
        }
    }
}
