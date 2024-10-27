<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OverspendingNotification;
use App\Models\User;
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
        'budget_id', // Ensure 'budget_id' is fillable
        'user_id',
    ];

    protected $dates = ['date'];

    public static function boot()
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
     * The budget associated with the expense.
     */
    public function budget()
    {
        return $this->belongsTo(Budget::class, 'budget_id', 'id');
    }

    /**
     * Check if the expense causes overspending.
     */
    public function checkForOverspending()
    {
        // Retrieve the associated budget via budget_id
        $budget = $this->budget;

        if ($budget && $budget->overspending_reminder) {
            // Calculate total expenses in the current budget period
            $totalExpenses = Expense::where('budget_id', $budget->id)
                ->where('user_id', $this->user_id)
                ->sum('amount');

            if ($totalExpenses > $budget->amount) {
                // Dispatch the OverspendingNotification
                $this->user->notify(new OverspendingNotification($budget, $totalExpenses));
            }
        }
    }
}
