<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Tentukan folder temporary untuk serverless Vercel
$storagePath = '/tmp/storage';
$cachePath = '/tmp/bootstrap/cache';

if (!file_exists($storagePath . '/framework/views')) {
    mkdir($storagePath . '/framework/views', 0755, true);
}
if (!file_exists($storagePath . '/framework/cache')) {
    mkdir($storagePath . '/framework/cache', 0755, true);
}
if (!file_exists($storagePath . '/framework/sessions')) {
    mkdir($storagePath . '/framework/sessions', 0755, true);
}
if (!file_exists($storagePath . '/logs')) {
    mkdir($storagePath . '/logs', 0755, true);
}
if (!file_exists($cachePath)) {
    mkdir($cachePath, 0755, true);
}

// Maintenance Mode Check
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register Autoloader
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__.'/../bootstrap/app.php';

// Bind custom storage path
$app->useStoragePath($storagePath);

// Handle Request
$response = $app->handleRequest(Request::capture());

$response->send();