<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
            // Ensure cookies are sent only over HTTPS in production
            config([
                'session.secure' => true,
                // Choose appropriate SameSite for your app: 'lax' or 'strict'
                'session.same_site' => config('session.same_site', 'lax'),
            ]);
        }
    }
}
