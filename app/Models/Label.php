<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'color',
        'user_id'
    ];

    // Define the relationship with tasks
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

      public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
