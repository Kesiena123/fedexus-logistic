<?php

use App\Models\Shipment;
use App\Models\TrackingEvent;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$s = Shipment::first();
echo "=== METADATA ===\n";
print_r($s->metadata);
echo "\n=== ORIGIN ===\n";
print_r($s->origin_address);
echo "\n=== DEST ===\n";
print_r($s->destination_address);
echo "\n=== SENDER: {$s->sender_name}\n";
echo "=== RECIPIENT: {$s->recipient_name}\n";
echo "=== WEIGHT: {$s->weight_kg}\n";
echo "=== DECLARED: {$s->declared_value}\n";
echo "=== QUOTED: {$s->quoted_amount}\n";
echo "\n=== ATTACHMENTS ===\n";
$atts = $s->attachments()->get();
echo $atts->toJson(JSON_PRETTY_PRINT)."\n";
echo "\n=== TRACKING EVENTS ===\n";
$events = TrackingEvent::where('shipment_id', $s->id)->orderBy('occurred_at')->get();
echo $events->toJson(JSON_PRETTY_PRINT)."\n";
