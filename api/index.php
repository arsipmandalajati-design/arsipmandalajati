<?php

// Dipakai untuk mengarahkan storage & cache Laravel ke folder temporer Vercel (/tmp)
$appDir = __DIR__ . '/..';

$_ENV['APP_STORAGE_PATH'] = '/tmp/storage';
$_ENV['APP_CONFIG_CACHE'] = '/tmp/bootstrap/cache/config.php';
$_ENV['APP_SERVICES_CACHE'] = '/tmp/bootstrap/cache/services.php';
$_ENV['APP_PACKAGES_CACHE'] = '/tmp/bootstrap/cache/packages.php';
$_ENV['APP_ROUTES_CACHE'] = '/tmp/bootstrap/cache/routes.php';

// Buat direktori yang dibutuhkan di /tmp jika belum ada
$dirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/bootstrap/cache',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Jalankan Laravel public/index.php
require $appDir . '/public/index.php';