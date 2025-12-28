<?php
$base = 'http://127.0.0.1:8000/properties';
$opts = ["http"=>["method"=>"GET","header"=>"User-Agent: PHP" ]];
$context = stream_context_create($opts);
$html = @file_get_contents($base, false, $context);
if ($html === false) { echo "Failed to fetch page\n"; exit(1); }
$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($html);
$imgs = $dom->getElementsByTagName('img');
foreach ($imgs as $img) {
    $src = $img->getAttribute('src');
    $headers = @get_headers($src, 1);
    $status = $headers ? $headers[0] : 'NO RESPONSE';
    echo $src . ' -> ' . $status . PHP_EOL;
}
