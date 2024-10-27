<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'balance', 'currency', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
