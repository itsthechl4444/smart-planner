<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_name',
        'description',
        'amount',
        'date',
        'user_id', // Add user_id to fillable
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
