<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

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

    public function tenants(Request $request)
    {

        $this->authorize('viewAny', User::class);

        $search = trim((string) $request->query('q', ''));
        $activeBooking = $request->query('active_booking');
        $minBookings = $request->query('min_bookings');

        $query = User::query()
            ->where('role', User::ROLE_TENANT)
            ->withCount([
                'bookings as bookings_count',
                'bookings as active_bookings_count' => function ($q) {
                    $q->where('status', 'active');
                },
            ]);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Relational filtering demo: users that have (or don't have) active bookings.
        if ($activeBooking === '1') {
            $query->whereHas('bookings', function ($q) {
                $q->where('status', 'active');
            });
        } elseif ($activeBooking === '0') {
            $query->whereDoesntHave('bookings', function ($q) {
                $q->where('status', 'active');
            });
        }

        // Relational filtering demo: users with at least N total bookings.
        if (is_numeric($minBookings)) {
            $query->has('bookings', '>=', (int) $minBookings);
        }

        $tenants = $query->latest()->get();

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
