<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Expense;
use Carbon\Carbon;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'amount',
        'category',
        'date',
        'period',
        'currency',
        'account_id',
        'overspending_reminder',
        'user_id',
    ];

    /**
     * The account associated with the budget.
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * The user who owns the budget.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

     /**
     * Get the start date of the budget period.
     */
    public function getStartDateAttribute()
    {
        if ($this->period === 'week') {
            return Carbon::parse($this->date)->startOfWeek();
        } elseif ($this->period === 'month') {
            return Carbon::parse($this->date)->startOfMonth();
        } else {
            // Default to date of the budget
            return Carbon::parse($this->date)->startOfDay();
        }
    }

    /**
     * Get the end date of the budget period.
     */
    public function getEndDateAttribute()
    {
        if ($this->period === 'week') {
            return Carbon::parse($this->date)->endOfWeek();
        } elseif ($this->period === 'month') {
            return Carbon::parse($this->date)->endOfMonth();
        } else {
            // Default to date of the budget
            return Carbon::parse($this->date)->endOfDay();
        }
    }

    public function expenses()
{
    return $this->hasMany(Expense::class, 'category', 'category')
                ->whereBetween('date', [$this->startDate(), $this->endDate()]);
}


  /**
     * Accessor to calculate total spent within this budget.
     */
    public function getSpentAttribute()
{
    return $this->expenses()->sum('amount');
}


    /**
 * Accessor to calculate remaining budget.
 */
public function getRemainingAttribute()
{
    return max($this->amount - $this->spent, 0);
}

public function startDate()
{
    if ($this->period === 'week') {
        return Carbon::parse($this->date)->startOfWeek();
    } elseif ($this->period === 'month') {
        return Carbon::parse($this->date)->startOfMonth();
    }
    // Add other periods if necessary
}

public function endDate()
{
    if ($this->period === 'week') {
        return Carbon::parse($this->date)->endOfWeek();
    } elseif ($this->period === 'month') {
        return Carbon::parse($this->date)->endOfMonth();
    }

}
}