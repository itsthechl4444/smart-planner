<?php

// app/Models/Project.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ProjectTask;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'user_id', // Owner's ID
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Owner of the project.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

       /**
     * Get the collaborators of the project.
     */
    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'project_user', 'project_id', 'user_id')
                    ->withPivot('status')
                    ->wherePivot('status', 'accepted')
                    ->withTimestamps();
    }

    /**
     * Accepted collaborators.
     */
    public function acceptedCollaborators()
    {
        return $this->collaborators()->wherePivot('status', 'accepted');
    }

    /**
     * Pending collaborators.
     */
    public function pendingCollaborators()
    {
        return $this->collaborators()->wherePivot('status', 'pending');
    }

    /**
     * Declined collaborators.
     */
    public function declinedCollaborators()
    {
        return $this->collaborators()->wherePivot('status', 'declined');
    }

    /**
     * Tasks associated with the project.
     */
    public function tasks()
    {
        return $this->hasMany(ProjectTask::class);
    }
}
