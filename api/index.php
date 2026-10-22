<?php

// 1. Tangkap Request & Set Root Path
define('LARAVEL_START', microtime(true));

// 2. Tentukan Direktori Storage & Cache ke /tmp (Wajib untuk Vercel Serverless)
$_ENV['APP_STORAGE'] = '/tmp/storage';
putenv('APP_STORAGE=/tmp/storage');

// Pastikan folder /tmp/storage ada
if (!is_dir('/tmp/storage')) {
    mkdir('/tmp/storage', 0777, true);
    mkdir('/tmp/storage/framework', 0777, true);
    mkdir('/tmp/storage/framework/views', 0777, true);
    mkdir('/tmp/storage/framework/cache', 0777, true);
    mkdir('/tmp/storage/framework/sessions', 0777, true);
    mkdir('/tmp/storage/logs', 0777, true);
}

// 3. Muat Composer Autoloader
require __DIR__ . '/../vendor/autoload.php';

// 4. Inisialisasi Aplikasi Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 5. Timpa Storage Path & Cache Path ke /tmp
$app->useStoragePath('/tmp/storage');
$app->useBootstrapPath('/tmp/bootstrap');

// 6. Jalankan Migrasi Otomatis ke Supabase (Opsional tapi aman untuk inisialisasi awal)
try {
    $app->make(\Illuminate\Contracts\Console\Kernel::class)->call('migrate', ['--force' => true]);
} catch (\Exception $e) {
    // Abaikan jika migrasi sudah pernah berjalan sebelumnya
}

// 7. Jalankan Request
$response = $app->handleRequest(Request::capture());

$response->send();