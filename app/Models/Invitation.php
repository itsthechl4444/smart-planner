<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    // Define the table name if different from the plural form of the model name
    protected $table = 'invitations';

    // Define fillable fields
    protected $fillable = [
        'inviter_id',
        'invitee_id',
        'project_id',
        'token',
        'accepted',
    ];


    // Invitation belongs to an inviter (user)
    public function inviter()
    {
        return $this->belongsTo(User::class, 'inviter_id');
    }

    // Invitation belongs to an invitee (user)
    public function invitee()
    {
        return $this->belongsTo(User::class, 'invitee_id');
    }

    // Invitation belongs to a project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    
}
