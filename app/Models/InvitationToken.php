<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvitationToken extends Model
{
    protected $fillable = ['project_id', 'email', 'token'];
}
