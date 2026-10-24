<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- Tambahkan ini di atas jika belum ada

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
        // Paksa HTTPS di Vercel atau environment production
        if (config('app.env') !== 'local' || isset($_ENV['VERCEL']) || getenv('VERCEL')) {
            URL::forceScheme('https');
        }
    }
}