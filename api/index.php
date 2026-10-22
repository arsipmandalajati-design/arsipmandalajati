<?php

// Paksa direktori storage dan bootstrap cache dialihkan ke /tmp (writable di Vercel)
$_ENV['APP_STORAGE'] = '/tmp/storage';

putenv('APP_STORAGE=/tmp/storage');
$__temp_storage = '/tmp/storage';

if (!is_dir($__temp_storage)) {
    mkdir($__temp_storage, 0755, true);
    mkdir($__temp_storage . '/app', 0755, true);
    mkdir($__temp_storage . '/framework', 0755, true);
    mkdir($__temp_storage . '/framework/cache', 0755, true);
    mkdir($__temp_storage . '/framework/sessions', 0755, true);
    mkdir($__temp_storage . '/framework/views', 0755, true);
    mkdir($__temp_storage . '/logs', 0755, true);
}

// Salin konfigurasi agar mengarah ke /tmp
$_ENV['APP_CONFIG_CACHE'] = '/tmp/config.php';
$_ENV['APP_ROUTES_CACHE'] = '/tmp/routes.php';
$_ENV['APP_SERVICES_CACHE'] = '/tmp/services.php';
$_ENV['APP_PACKAGES_CACHE'] = '/tmp/packages.php';

require __DIR__ . '/../public/index.php';