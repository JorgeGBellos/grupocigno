<?php

$db = __DIR__.'/database/database.sqlite';
if (! is_file($db)) {
    fwrite(STDERR, "DB missing: $db\n");
    exit(1);
}

$pdo = new PDO('sqlite:'.$db);
$map = [
    'classic-room-king' => 'images/mejorada/rooms/classic-room-king.jpg',
    'deluxe-room-plunge-pool' => 'images/mejorada/rooms/deluxe-room-plunge-pool.jpg',
    'jr-suite-private-terrace-plunge-pool' => 'images/mejorada/rooms/jr-suite-private-terrace-plunge-pool.jpg',
    'garden-jr-suite-plunge-pool' => 'images/mejorada/rooms/garden-jr-suite-plunge-pool.jpg',
    'villa-deluxe' => 'images/mejorada/rooms/villa-deluxe.jpg',
    'villa-deluxe-bathtub' => 'images/mejorada/rooms/villa-deluxe-bathtub.jpg',
    'villa-suite-bathtub' => 'images/mejorada/rooms/villa-suite-bathtub.jpg',
    'master-weddings-suite' => 'images/mejorada/rooms/master-weddings-suite.jpg',
    'jr-suite-2-beds-balcony' => 'images/mejorada/rooms/jr-suite-2-beds-balcony.jpg',
    'master-suite-plunge-pool' => 'images/mejorada/rooms/master-suite-plunge-pool.jpg',
    'jr-suite-balcony-garden-view' => 'images/mejorada/rooms/jr-suite-balcony-garden-view.jpg',
    'master-suite-double' => 'images/mejorada/rooms/master-suite-double.jpg',
];

$st = $pdo->prepare('UPDATE mejorada_rooms SET image = ? WHERE slug = ?');
foreach ($map as $slug => $image) {
    $st->execute([$image, $slug]);
    echo "$slug -> $image ({$st->rowCount()})\n";
}

echo "DONE\n";
