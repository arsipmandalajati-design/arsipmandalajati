<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Jika dijalankan di Vercel (sistem serverless), ubah lokasi storage ke /tmp
if (isset($_ENV['VERCEL']) || getenv('VERCEL') || file_exists('/tmp')) {
    $_ENV['APP_STORAGE'] = '/tmp/storage';
    putenv('APP_STORAGE=/tmp/storage');
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();