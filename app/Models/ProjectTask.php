<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\ProjectTaskReminderNotification;
use App\Models\Project;
use App\Models\User;
use App\Models\Label;
use Illuminate\Support\Facades\Log;

class ProjectTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'priority',
        'project_id',
        'notes',
        'attachments',
        'reminder',
        'status',      // Ensure 'status' is fillable
        'user_id',     // Ensure 'user_id' is fillable
    ];

    protected $casts = [
        'reminder' => 'boolean',
        'due_date' => 'date',
        'status' => 'string', // Cast 'status' to string
    ];

    protected $dates = ['due_date'];

    /**
     * The project this task belongs to.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * The label associated with the task.
     */
    public function label()
    {
        return $this->belongsTo(Label::class);
    }

    /**
     * The user assigned to the task.
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Mark the task as completed.
     */
    public function markAsCompleted()
    {
        $this->status = 'completed';
        $this->save();
    }

    /**
     * Send due date reminder if applicable.
     */
    public function sendDueDateReminder()
    {
        if ($this->reminder && $this->due_date->isToday()) {
            if ($this->assignedUser) {
                try {
                    $this->assignedUser->notify(new ProjectTaskReminderNotification($this));
                    Log::info("ProjectTaskReminderNotification: Notification sent to user ID {$this->assignedUser->id} for task ID {$this->id}.");
                } catch (\Exception $e) {
                    Log::error("ProjectTaskReminderNotification: Failed to send notification for task ID {$this->id}. Error: {$e->getMessage()}");
                }
            } else {
                Log::warning("ProjectTaskReminderNotification: No assigned user found for task ID {$this->id}.");
            }
        }
    }
}
