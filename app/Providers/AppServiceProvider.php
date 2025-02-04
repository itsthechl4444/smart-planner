<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\ChannelManager;
use App\Channels\PHPMailerChannel; // Import the PHPMailerChannel
use App\Services\PHPMailerService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Bind PHPMailerService as a singleton
        $this->app->singleton(PHPMailerService::class, function ($app) {
            return new PHPMailerService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Extend the Notification Channel Manager with PHPMailerChannel
        $this->app->make(ChannelManager::class)->extend('phpmailer', function ($app) {
            return new PHPMailerChannel();
        });
    }
}
