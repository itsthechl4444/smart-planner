<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\OverspendingNotification;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'amount',
        'category',
        'date',
        'currency',
        'payment_method',
        'notes',
        'attachment',
        'user_id',
    ];

    protected $dates = ['date'];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Boot method to attach model events.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($expense) {
            $expense->checkForOverspending();
        });
    }

    /**
     * The user who made the expense.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The budget associated with the expense via category.
     */
    public function budget()
    {
        return $this->belongsTo(Budget::class, 'category', 'category');
    }

    /**
     * Check if the expense causes overspending.
     */
    public function checkForOverspending()
    {
        // Retrieve the associated budget via category and user_id
        $budget = Budget::where('category', $this->category)
                        ->where('user_id', $this->user_id)
                        ->where('overspending_reminder', true)
                        ->first();

        if ($budget) {
            // Calculate total expenses in the current budget period
            $totalExpenses = Expense::where('category', $this->category)
                ->where('user_id', $this->user_id)
                ->whereBetween('date', [$budget->start_date, $budget->end_date]) // Corrected to snake_case
                ->sum('amount');

            Log::info("Expense: Total expenses for budget ID {$budget->id} is {$totalExpenses}.");

            if ($totalExpenses > $budget->amount) {
                // Dispatch the OverspendingNotification
                try {
                    $this->user->notify(new OverspendingNotification($budget, $totalExpenses));
                    Log::info("Expense: OverspendingNotification dispatched to user ID {$this->user->id} for budget ID {$budget->id}.");
                } catch (\Exception $e) {
                    Log::error("Expense: Failed to dispatch OverspendingNotification. Error: {$e->getMessage()}");
                }
            }
        } else {
            Log::info("Expense: No applicable budget found for category '{$this->category}' and user ID {$this->user_id}.");
        }
    }
}
