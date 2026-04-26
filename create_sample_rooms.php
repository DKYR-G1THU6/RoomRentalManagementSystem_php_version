<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Create sample rooms
\App\Models\Room::create([
    'room_number' => '101',
    'type' => 'Standard Single Room',
    'price' => 288,
    'description' => 'Comfortable single room with private bathroom and WiFi',
    'status' => 'available',
]);

\App\Models\Room::create([
    'room_number' => '102',
    'type' => 'Standard Double Room',
    'price' => 388,
    'description' => 'Cozy double room suitable for couples or small families, equipped with modern facilities',
    'status' => 'available',
]);

\App\Models\Room::create([
    'room_number' => '103',
    'type' => 'Deluxe Suite',
    'price' => 688,
    'description' => 'Luxury suite including living room, bedroom, and bathroom, offering five-star service',
    'status' => 'available',
]);

\App\Models\Room::create([
    'room_number' => '104',
    'type' => 'Business Twin Room',
    'price' => 498,
    'description' => 'Specially designed for business travelers, equipped with a work area and high-speed internet',
    'status' => 'available',
]);

echo "Successfully created 4 sample rooms!\n";
$rooms = \App\Models\Room::all();
foreach ($rooms as $room) {
    echo "   Room #" . $room->room_number . " (" . $room->type . ") - RM" . $room->price . "/night\n";
}
