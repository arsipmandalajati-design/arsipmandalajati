<?php

// 1. Set environment variable storage & cache ke /tmp
$_ENV['APP_STORAGE'] = '/tmp/storage';
putenv('APP_STORAGE=/tmp/storage');

$_ENV['APP_CONFIG_CACHE'] = '/tmp/config.php';
putenv('APP_CONFIG_CACHE=/tmp/config.php');

$_ENV['APP_ROUTES_CACHE'] = '/tmp/routes.php';
putenv('APP_ROUTES_CACHE=/tmp/routes.php');

$_ENV['APP_SERVICES_CACHE'] = '/tmp/services.php';
putenv('APP_SERVICES_CACHE=/tmp/services.php');

// 2. Buat direktori /tmp jika belum ada
$dirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache'
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// 3. Load Autoload & App
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 4. Bind path storage & bootstrap cache ke /tmp
$app->useStoragePath('/tmp/storage');
$app->useBootstrapPath('/tmp/bootstrap');

// 5. Handle Request
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);