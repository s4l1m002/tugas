<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\DB;

// Map property id -> existing filename to use
$map = [
    13 => 'V00pyD7vmKlOteRPuVgRIv608nfp2EY5IcOLHvjj.jpg', // reuse existing image
    14 => 'yHXo7awqp8qW4ZhligPJMhxgXfsByJ2YtxdgmPmx.jpg',
];

foreach ($map as $id => $file) {
    $path = 'storage/properties/' . $file;
    $updated = DB::table('properties')->where('id', $id)->update(['gambar' => $path]);
    echo "id={$id} -> set gambar={$path} (updated: ".($updated? 'yes':'no').")\n";
}
