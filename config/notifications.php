<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Notification Channel
    |--------------------------------------------------------------------------
    |
    | This option controls the default notification channel that will be used
    | to deliver any notifications that are sent by your application. You
    | may set this to any channel specified in the "channels" section.
    |
    */

    'default' => env('NOTIFICATION_CHANNEL', 'mail'),

    /*
    |--------------------------------------------------------------------------
    | Notification Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the notification channels used by your application.
    | A variety of channels are supported, including email, SMS, and more.
    |
    */

    'channels' => [

        'mail' => [
            'driver' => 'mail',
        ],

        'database' => [
            'driver' => 'database',
        ],

        'broadcast' => [
            'driver' => 'broadcast',
        ],

        'slack' => [
            'driver' => 'slack',
        ],

        // Add more channels as required
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Drivers
    |--------------------------------------------------------------------------
    |
    | You may configure the notification drivers that your application uses
    | to send notifications via different channels, such as email, SMS, etc.
    |
    */

    'drivers' => [

        'mail' => [
            'transport' => env('MAIL_DRIVER', 'smtp'),
        ],

        'database' => [
            'table' => 'notifications',
        ],

    ],

];
