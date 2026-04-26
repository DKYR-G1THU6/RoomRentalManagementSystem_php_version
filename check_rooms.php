<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$rooms = \App\Models\Room::all();
echo "Total rooms: " . count($rooms) . "\n";
echo "Available rooms: " . \App\Models\Room::where('status', 'available')->count() . "\n\n";

foreach ($rooms as $room) {
    echo "Room #" . $room->room_number . " - Type: " . $room->type . " - Price: RM" . $room->price . " - Status: " . $room->status . "\n";
}
