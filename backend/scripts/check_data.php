<?php

use Illuminate\Contracts\Http\Kernel;

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$gateways = App\Models\PaymentSetting::where('is_active', true)->get();
echo "Active gateways: " . $gateways->count() . "\n";
foreach ($gateways as $g) {
    echo "  - {$g->gateway_name} (mode: {$g->mode}, currency: {$g->currency})\n";
}

$prs = App\Models\PaymentRequest::with('shipment')->get();
echo "\nPayment requests: " . $prs->count() . "\n";
foreach ($prs as $pr) {
    echo "  - ID: {$pr->id}, token: " . substr($pr->secure_token ?? 'NULL', 0, 20) . "..., status: {$pr->status}, amount: {$pr->amount}\n";
}
