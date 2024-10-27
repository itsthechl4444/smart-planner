<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\TaskReminderNotification;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory; // Removed Notifiable

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'due_date',
        'priority',
        'label_id',
        'notes',
        'attachments',
        'reminder',
        'status',
    ];

    protected $casts = [
        'reminder' => 'boolean',
        'due_date' => 'datetime',
    ];

    protected $dates = ['due_date'];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function label()
    {
        return $this->belongsTo(Label::class);
    }

    // Send due date reminder
    public function sendDueDateReminder()
    {
        $user = $this->user;
        if ($user && $this->reminder && $this->due_date->isToday()) {
            $user->notify(new TaskReminderNotification($this));
        }
    }

    // Mark as completed
    public function markAsCompleted()
    {
        $this->status = 'completed';
        $this->save();
    }
}
