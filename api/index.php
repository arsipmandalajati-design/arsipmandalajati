<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

echo "<h1>Debug Step 1: Cek Autoload</h1><br>";

try {
    require __DIR__ . '/../vendor/autoload.php';
    echo "✔ Autoload Berhasil!<br>";

    $app = require_once __DIR__ . '/../bootstrap/app.php';
    echo "✔ Bootstrap App Berhasil!<br>";

} catch (\Throwable $e) {
    echo "<h3 style='color:red;'>❌ Error Tertangkap:</h3>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "\n\n" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}