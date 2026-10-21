<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Setup temporary storage for Vercel Serverless Environment
$storageFolders = [
    '/tmp/storage/app',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache',
];

foreach ($storageFolders as $folder) {
    if (!file_exists($folder)) {
        @mkdir($folder, 0755, true);
    }
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Auto Loader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
$app = require_once __DIR__.'/../bootstrap/app.php';

// Override storage path to /tmp
$app->useStoragePath('/tmp/storage');

$response = $app->handleRequest(Request::capture());

$response->send();