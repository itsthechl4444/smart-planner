<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectUser extends Pivot
{
    use HasFactory;

    protected $table = 'project_user'; // Plural

    protected $fillable = [
        'project_id',
        'user_id',
        'status',
    ];

    /**
     * Get the project associated with the pivot.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the user associated with the pivot.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
