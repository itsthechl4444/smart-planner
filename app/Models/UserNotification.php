<?php

namespace App\Models;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Str;

class UserNotification extends DatabaseNotification
{
    protected $keyType = 'string'; // Specify that the primary key is a string
    public $incrementing = false;  // Disable auto-incrementing

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($notification) {
            if (empty($notification->id)) {
                $notification->id = (string) Str::uuid(); // Generate a UUID when creating a notification
            }
        });
    }
}
