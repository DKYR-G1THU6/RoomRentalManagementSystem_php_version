<?php

namespace App\Http\Controllers;

class TenantController extends Controller
{ 
    /**
     * Tenant dashboard showing booking stats and recent bookings.
     */
    public function dashboard()
    {
        $user = auth()->user();
        $bookings = $user->bookings()->with('room')->get();
        
        $stats = [
            'active_bookings' => $bookings->where('status', 'active')->count(),
            'pending_bookings' => $bookings->where('status', 'pending')->count(),
            'completed_bookings' => $bookings->where('status', 'completed')->count(),
        ];

        return view('tenant.dashboard', compact('stats', 'bookings'));
    }
}
