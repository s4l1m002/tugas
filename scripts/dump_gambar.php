<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\DB;
$rows = DB::table('properties')->select('id','gambar')->limit(20)->get();
foreach ($rows as $r) {
    echo $r->id . " => " . ($r->gambar ?? '(null)') . PHP_EOL;
}
