<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\SavingAmount;

class Saving extends Model
{
    protected $fillable = [
        'name',
        'description',
        'desired_amount',
        'desired_date',
        'notes',
        'attachment',
        'user_id',  // Add user_id to fillable attributes
    ];


    protected $dates = ['desired_date'];
    protected $casts = [
        'desired_date' => 'date',
    ];
    


    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

     // Define the relationship to SavingAmount
     public function amounts()
     {
         return $this->hasMany(SavingAmount::class);
     }

    // Total saved amount across all related SavingAmount records
    public function getTotalSavedAttribute()
    {
        return $this->amounts()->sum('amount');  // Summing all amounts related to this saving goal
    }

    // Remaining amount to reach the desired saving goal
    public function getRemainingAmountAttribute()
    {
        return $this->desired_amount - $this->total_saved;  // Subtract total saved from desired amount
    }
}
