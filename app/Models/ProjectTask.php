<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\ProjectTaskReminderNotification;
use App\Models\Project;
use App\Models\User;
use App\Models\Label;

class ProjectTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'priority',
        'label_id',
        'project_id',
        'notes',
        'attachments',
        'reminder',
        'status',
    ];

    protected $casts = [
        'reminder' => 'boolean',
        'due_date' => 'date',
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
            $this->assignedUser->notify(new ProjectTaskReminderNotification($this));
        }
    }
}
