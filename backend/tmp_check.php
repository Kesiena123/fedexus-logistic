<?php

use App\Models\Warehouse;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo 'Warehouses: '.Warehouse::count()."\n";
Warehouse::all()->each(function ($w) {
    echo "  {$w->code} - {$w->name} ({$w->city}, {$w->country})\n";
});

echo "\nUsers by role:\n";
DB::table('users')->select('role', DB::raw('count(*) as cnt'))->groupBy('role')->get()->each(function ($r) {
    echo "  {$r->role}: {$r->cnt}\n";
});
