<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\DebtDeadlineNotification;
use App\Models\User;
use Illuminate\Notifications\Notifiable; 

class Debt extends Model
{
    use HasFactory, notifiable;

    protected $fillable = [
        'name',
        'description',
        'amount',
        'currency',
        'type', // e.g., 'borrowed' or 'lent'
        'due_date',
        'user_id',
        'reminder', // Boolean to indicate if reminder is set
    ];
    

    protected $casts = [
        'due_date' => 'date',
        'reminder' => 'boolean',
    ];

    protected $dates = ['due_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

     /**
     * Send due date reminder if due today.
     */
    public function sendDueDateReminder()
    {
        if ($this->reminder && $this->due_date->isToday()) {
            $this->user->notify(new DebtDeadlineNotification($this));
        }
    }
    
}
