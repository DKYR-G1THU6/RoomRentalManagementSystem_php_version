<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Booking;

class AdminController extends Controller
{
    /**
     * 管理员仪表板
     */
    public function dashboard()
    {
        $stats = [
            'total_rooms' => Room::count(),
            'available_rooms' => Room::where('status', 'available')->count(),
            'rented_rooms' => Room::where('status', 'rented')->count(),
            'maintenance_rooms' => Room::where('status', 'maintenance')->count(),
            'total_tenants' => User::where('role', 'tenant')->count(),
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'active_bookings' => Booking::where('status', 'active')->count(),
        ];

        $recentBookings = Booking::with('user', 'room')->latest()->limit(10)->get();
        $pendingBookings = Booking::with('user', 'room')->where('status', 'pending')->get();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'pendingBookings'));
    }

    /**
     * 管理员查看租客列表
     */
    public function tenants()
    {
        $tenants = User::where('role', 'tenant')->with('bookings')->latest()->get();
        return view('admin.tenants.index', compact('tenants'));
    }

    /**
     * 删除租客账号（管理员）
     */
    public function deleteTenant(User $user)
    {
        if ($user->role !== 'tenant') {
            return redirect()->route('admin.tenants')->with('error', '只能删除租客账号');
        }

        // 删除其关联的预订
        $user->bookings()->delete();
        
        // 删除租客
        $user->delete();

        return redirect()->route('admin.tenants')->with('success', '租客账号已删除');
    }
}
