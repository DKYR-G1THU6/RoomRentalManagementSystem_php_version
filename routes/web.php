<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// 重定向 /dashboard 根据用户角色
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('tenant.rooms');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 租客路由
Route::middleware(['auth', 'verified'])->prefix('tenant')->name('tenant.')->group(function () {
    // 任何访问仪表板的租客都被重定向到房间列表
    Route::redirect('/dashboard', '/tenant/rooms');
    
    // 房间浏览
    Route::get('/rooms', [BookingController::class, 'availableRooms'])->name('rooms');
    Route::get('/rooms/{room}/book', [BookingController::class, 'bookRoom'])->name('book-room');
    Route::post('/rooms/{room}/book', [BookingController::class, 'storeBooking'])->name('store-booking');
    
    // 预订管理
    Route::get('/bookings', [BookingController::class, 'myBookings'])->name('bookings.my');
    Route::delete('/bookings/{booking}/cancel', [BookingController::class, 'cancelBooking'])->name('bookings.cancel');
});

// 管理员路由
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    // 管理员仪表板
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // 房间管理
    Route::resource('rooms', RoomController::class);
    
    // 预订管理
    Route::get('/bookings', [BookingController::class, 'allBookings'])->name('bookings.index');
    Route::post('/bookings/{booking}/approve', [BookingController::class, 'approveBooking'])->name('bookings.approve');
    Route::post('/bookings/{booking}/reject', [BookingController::class, 'rejectBooking'])->name('bookings.reject');
    Route::post('/bookings/{booking}/complete', [BookingController::class, 'completeBooking'])->name('bookings.complete');
    
    // 租客管理
    Route::get('/tenants', [AdminController::class, 'tenants'])->name('tenants');
    Route::delete('/tenants/{user}', [AdminController::class, 'deleteTenant'])->name('tenants.delete');
});

require __DIR__.'/auth.php';
