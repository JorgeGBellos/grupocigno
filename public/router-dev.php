<?php

/**
 * Router for PHP built-in server: serve real files, otherwise Laravel.
 * Usage: php -S 127.0.0.1:8088 -t public public/router-dev.php
 */

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$path = rawurldecode($path);

$miraiPages = [
    '/bookingstep1' => '/bookingstep1.html',
    '/bookingstep2' => '/bookingstep2.html',
    '/bookingstep3' => '/bookingstep3.html',
    '/signup' => '/signup.html',
    '/profile' => '/profile.html',
];

$normalized = rtrim($path, '/') ?: '/';
if (isset($miraiPages[$normalized])) {
    $path = $miraiPages[$normalized];
}

$file = __DIR__.$path;

if ($path !== '/' && is_file($file)) {
    return false;
}

require __DIR__.'/index.php';