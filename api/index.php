<?php

// Persiapan direktori temporary untuk Vercel Serverless
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
        mkdir($folder, 0755, true);
    }
}

// Redirect storage path ke /tmp agar bisa ditulis di serverless Vercel
app()->useStoragePath('/tmp/storage');

// Forward request to the public/index.php
require __DIR__ . '/../public/index.php';