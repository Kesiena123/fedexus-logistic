<?php

use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Hash;

require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$warehouses = [
    ['name' => 'Memphis Global Hub', 'code' => 'MEM', 'city' => 'Memphis', 'country' => 'US'],
    ['name' => 'Heathrow Gateway Hub', 'code' => 'LHR', 'city' => 'London', 'country' => 'GB'],
    ['name' => 'Dubai Transit Center', 'code' => 'DXB', 'city' => 'Dubai', 'country' => 'AE'],
    ['name' => 'Lagos Coastal Hub', 'code' => 'LOS', 'city' => 'Lagos', 'country' => 'NG'],
    ['name' => 'Sao Paulo Cargo Hub', 'code' => 'GRU', 'city' => 'Sao Paulo', 'country' => 'BR'],
];

foreach ($warehouses as $w) {
    Warehouse::firstOrCreate(['code' => $w['code']], $w);
}

echo 'Warehouses: '.Warehouse::count()."\n";
Warehouse::all()->each(function ($w) {
    echo "  {$w->code} - {$w->name}\n";
});

// Create driver user
$driver = User::firstOrCreate(
    ['email' => 'driver@freightflow.test'],
    ['name' => 'James Driver', 'password' => Hash::make('Password123!'), 'role' => 'driver']
);
echo "\nDriver user: {$driver->email} ({$driver->role})\n";
