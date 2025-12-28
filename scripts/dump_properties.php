<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\DB;
$rows = DB::table('properties')->select('id','judul','gambar')->orderBy('id')->get();
foreach ($rows as $r) {
    $gambar = $r->gambar ?: '(null)';
    $path = preg_replace('#^storage/#','',$gambar);
    $fs = $path ? realpath(__DIR__ . '/../storage/app/public/' . $path) : '(no file)';
    $exists = $fs && file_exists($fs) ? 'OK' : 'MISSING';
    echo sprintf("id=%d | judul=%s | gambar=%s | file=%s | %s\n", $r->id, $r->judul, $gambar, $fs ?: '(no file)', $exists);
}
