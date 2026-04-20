<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Admin dashboard.
     */
    public function dashboard()
    {
        $this->authorize('access-admin');

        $stats = [
            'total_rooms' => Room::count(),
            'available_rooms' => Room::where('status', 'available')->count(),
            'rented_rooms' => Room::where('status', 'rented')->count(),
            'maintenance_rooms' => Room::where('status', 'maintenance')->count(),
            'total_tenants' => User::where('role', User::ROLE_TENANT)->count(),
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'active_bookings' => Booking::where('status', 'active')->count(),
        ];

        $recentBookings = Booking::with('user', 'room')->latest()->limit(10)->get();
        $pendingBookings = Booking::with('user', 'room')->where('status', 'pending')->get();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'pendingBookings'));
    }

    /**
     * Admin views tenant list.
     */
    public function tenants()
    {
        $this->authorize('viewAny', User::class);

        $tenants = User::where('role', User::ROLE_TENANT)->with('bookings')->latest()->get();

        return view('admin.tenants.index', compact('tenants'));
    }

    /**
     * Admin deletes a tenant account.
     */
    public function deleteTenant(User $user)
    {
        $this->authorize('delete', $user);

        $user->bookings()->delete();
        $user->delete();

        return redirect()->route('admin.tenants')->with('success', 'Tenant account deleted successfully.');
    }
}
