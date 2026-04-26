<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
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

//-----------------------------------------------------------------
// redirect /dashboard according to user role
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user && $user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user) {
        return redirect()->route('tenant.rooms');
    }
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');
//------------------------------------------------------------------

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// tenant routes
Route::middleware(['auth', 'verified', 'can:access-tenant'])->prefix('tenant')->name('tenant.')->group(function () {
    // any tenant visits dashboard, redirect to room list
    Route::redirect('/dashboard', '/tenant/rooms');
    
    // room browsing
    Route::get('/rooms', [BookingController::class, 'availableRooms'])->name('rooms');
    Route::get('/rooms/{room}/book', [BookingController::class, 'bookRoom'])->name('book-room');
    Route::post('/rooms/{room}/book', [BookingController::class, 'storeBooking'])->name('store-booking');
    
    // booking management
    Route::get('/bookings', [BookingController::class, 'myBookings'])->name('bookings.my');
    Route::delete('/bookings/{booking}/cancel', [BookingController::class, 'cancelBooking'])->name('bookings.cancel');
});

// admin routes
Route::middleware(['auth', 'verified', 'can:access-admin'])->prefix('admin')->name('admin.')->group(function () {
    // admin dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // room management
    Route::resource('rooms', RoomController::class);
    
    // booking management
    Route::get('/bookings', [BookingController::class, 'allBookings'])->name('bookings.index');
    Route::post('/bookings/{booking}/approve', [BookingController::class, 'approveBooking'])->name('bookings.approve');
    Route::post('/bookings/{booking}/reject', [BookingController::class, 'rejectBooking'])->name('bookings.reject');
    Route::post('/bookings/{booking}/complete', [BookingController::class, 'completeBooking'])->name('bookings.complete');
    
    // tenant management
    Route::get('/tenants', [AdminController::class, 'tenants'])->name('tenants');
    Route::delete('/tenants/{user}', [AdminController::class, 'deleteTenant'])->name('tenants.delete');
});

require __DIR__.'/auth.php';
