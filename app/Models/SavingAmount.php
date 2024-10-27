<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingAmount extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'saving_id', 'amount'];

    // Relationship to Saving
    public function savingRelation()
    {
        return $this->belongsTo(Saving::class);
    }

    // Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
