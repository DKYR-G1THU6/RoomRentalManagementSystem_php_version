<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// 创建示例房间
\App\Models\Room::create([
    'room_number' => '101',
    'type' => '标准单人间',
    'price' => 288,
    'description' => '宽敞舒适的单人房间，配备独立卫浴和无线网络',
    'status' => 'available',
]);

\App\Models\Room::create([
    'room_number' => '102',
    'type' => '标准双人间',
    'price' => 388,
    'description' => '温馨的双人房间，适合情侣或小家庭，配备现代化设施',
    'status' => 'available',
]);

\App\Models\Room::create([
    'room_number' => '103',
    'type' => '豪华套房',
    'price' => 688,
    'description' => '高端豪华套房，包含客厅、卧室和浴室，享受五星级服务',
    'status' => 'available',
]);

\App\Models\Room::create([
    'room_number' => '104',
    'type' => '商务双床间',
    'price' => 498,
    'description' => '专为商务客人设计，配备办公区域和高速网络',
    'status' => 'available',
]);

echo "✅ 已成功创建 4 间示例房间!\n";
$rooms = \App\Models\Room::all();
foreach ($rooms as $room) {
    echo "   房间 #" . $room->room_number . " (" . $room->type . ") - ¥" . $room->price . "/晚\n";
}
