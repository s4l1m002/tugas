<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\DB;
$rows = DB::table('properties')->select('id','gambar')->get();
$missing = [];
foreach ($rows as $r) {
    if (!$r->gambar) continue;
    $path = preg_replace('#^storage/#', '', $r->gambar);
    $fs = __DIR__ . '/../storage/app/public/' . $path;
    if (!file_exists($fs)) {
        $missing[] = [$r->id, $r->gambar, $fs];
    }
}
if (empty($missing)) {
    echo "All images present\n";
} else {
    foreach ($missing as $m) {
        echo "Missing: id={$m[0]} db='{$m[1]}' expected_file='{$m[2]}'\n";
    }
}
