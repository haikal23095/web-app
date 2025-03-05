<?php
if (php_sapi_name() === 'cli-server') {
    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $file = __DIR__ . $url;
    if (is_file($file)) {
        return false; // Biarkan PHP menangani file statis.
    }
}

// Arahkan semua request ke index.php
require_once __DIR__ . '/loginpage.php';
