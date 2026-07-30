<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$req = Request::create('/tracking/FDX-RT-19EE1B', 'GET');
$resp = app()->handle($req);
$html = $resp->getContent();

echo "=== CSS Links in <head> ===\n";
preg_match('/<head>(.*?)<\/head>/s', $html, $head);
preg_match_all('/<link[^>]+href="([^"]+)"[^>]*>/', $head[1] ?? '', $links);
foreach ($links[1] as $l) {
    if (strpos($l, 'build/') !== false || strpos($l, '5173') !== false || strpos($l, 'app.css') !== false || strpos($l, 'leaflet') !== false) {
        echo "  $l\n";
    }
}

echo "\n=== Script tags ===\n";
preg_match_all('/<script[^>]*(?:src="([^"]*)")?[^>]*>/', $html, $scripts);
foreach ($scripts[0] as $s) {
    echo '  '.substr($s, 0, 120)."\n";
}

echo "\n=== Map Container ===\n";
preg_match('/id="shipment-route-map"[^>]*>/', $html, $mapEl);
echo '  '.($mapEl[0] ?? 'NOT FOUND')."\n";

echo "\n=== Map Unavailable overlay ===\n";
preg_match('/id="map-unavailable"[^>]*style="([^"]*)"/', $html, $unavail);
echo '  style='.($unavail[1] ?? 'NOT FOUND')."\n";

echo "\n=== Leaflet data ===\n";
echo '  Has window.L reference: '.(str_contains($html, 'window.L') ? 'YES' : 'NO')."\n";
echo '  Has L.map: '.(str_contains($html, 'L.map(') ? 'YES' : 'NO')."\n";
echo '  Has L.marker: '.(str_contains($html, 'L.marker(') ? 'YES' : 'NO')."\n";
echo '  Has L.polyline: '.(str_contains($html, 'L.polyline(') ? 'YES' : 'NO')."\n";
echo '  Has tile layer: '.(str_contains($html, 'tileLayer') ? 'YES' : 'NO')."\n";
echo '  Has CARTO tiles: '.(str_contains($html, 'cartocdn') ? 'YES' : 'NO')."\n";
echo '  Has Esri tiles: '.(str_contains($html, 'arcgisonline') ? 'YES' : 'NO')."\n";
echo '  Has OpenTopo tiles: '.(str_contains($html, 'opentopomap') ? 'YES' : 'NO')."\n";
echo '  Has static fallback: '.(str_contains($html, 'showStaticMap') ? 'YES' : 'NO')."\n";

preg_match('/var initialPoints = (.+?);/s', $html, $m);
echo '  initialPoints: '.($m[1] ?? 'NOT FOUND')."\n";

echo "\n=== Tailwind CSS overrides ===\n";
$css = file_get_contents(__DIR__.'/public/build/assets/app-cD491EPn.css');
echo '  .leaflet-container img max-width:none: '.(strpos($css, '.leaflet-container img') !== false ? 'YES' : 'NO')."\n";
echo '  .leaflet-container background: '.(strpos($css, '.leaflet-container{') !== false ? 'YES' : 'NO')."\n";
