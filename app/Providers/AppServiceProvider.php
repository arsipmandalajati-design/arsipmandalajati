<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- Tambihkeun ieu di luhur

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
        // Paksa HTTPS di serverless/production (Vercel)
        if (config('app.env') !== 'local' || isset($_SERVER['HTTPS'])) {
            URL::forceScheme('https');
        }
    }
}