<?php
$url = 'http://127.0.0.1:8000/properties';
$opts = ["http"=>["method"=>"GET","header"=>"User-Agent: PHP" ]];
$context = stream_context_create($opts);
libxml_use_internal_errors(true);
$html = @file_get_contents($url, false, $context);
if ($html === false) {
    echo "Failed to fetch $url\n";
    exit(1);
}
$dom = new DOMDocument();
$dom->loadHTML($html);
$imgs = $dom->getElementsByTagName('img');
foreach ($imgs as $img) {
    echo $img->getAttribute('src') . PHP_EOL;

}
