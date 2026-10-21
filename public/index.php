<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Buat struktur folder di /tmp untuk Vercel Serverless
$storageFolders = [
    '/tmp/storage/app/public',
    '/tmp/storage/framework/cache/data',
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

// 2. Check Maintenance Mode
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// 3. Register Autoloader
require __DIR__.'/../vendor/autoload.php';

// 4. Bootstrap Laravel Instance
$app = require_once __DIR__.'/../bootstrap/app.php';

// 5. Timpa Storage Path & Cache Path ke /tmp sebelum penanganan Request
$app->useStoragePath('/tmp/storage');
$app->useBootstrapPath('/tmp/bootstrap');

// 6. Jalankan Request
$response = $app->handleRequest(Request::capture());

$response->send();