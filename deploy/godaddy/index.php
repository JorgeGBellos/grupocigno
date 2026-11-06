<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
| GoDaddy / cPanel
| Document root = public_html (esta carpeta).
| La app Laravel vive en una carpeta hermana llamada cigno
| (mismo nivel que public_html), o en public_html/cigno si no
| puedes salir del document root.
*/

$candidates = [
    dirname(__DIR__).'/cigno',
    dirname(__DIR__, 2).'/cigno',
    __DIR__.'/cigno',
];

$laravelRoot = null;

foreach ($candidates as $candidate) {
    if (is_file($candidate.'/vendor/autoload.php')) {
        $laravelRoot = $candidate;
        break;
    }
}

if ($laravelRoot === null) {
    http_response_code(500);
    echo 'No se encontro la aplicacion Laravel (carpeta cigno con vendor/).';
    exit(1);
}

if (file_exists($maintenance = $laravelRoot.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $laravelRoot.'/vendor/autoload.php';

/** @var Application $app */
$app = require_once $laravelRoot.'/bootstrap/app.php';

$app->usePublicPath(__DIR__);

$app->handleRequest(Request::capture());
