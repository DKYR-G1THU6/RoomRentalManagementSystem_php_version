<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$rooms = \App\Models\Room::all();
echo "总房间数: " . count($rooms) . "\n";
echo "可用房间数: " . \App\Models\Room::where('status', 'available')->count() . "\n\n";

foreach ($rooms as $room) {
    echo "房间 #" . $room->room_number . " - 类型: " . $room->type . " - 价格: ¥" . $room->price . " - 状态: " . $room->status . "\n";
}
