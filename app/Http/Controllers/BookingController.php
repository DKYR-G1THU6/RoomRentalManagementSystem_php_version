<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{ 
    /**
     * tenant view available rooms
     */
    public function availableRooms()
    {
        // Exclude rooms that are still occupied (including completed orders with future end dates)
        $occupiedRoomIds = Booking::query()
            ->whereIn('status', ['active', 'completed'])
            ->whereDate('end_date', '>=', now()->toDateString())
            ->pluck('room_id');

        $rooms = Room::query()
            ->where('status', 'available')
            ->whereNotIn('id', $occupiedRoomIds)
            ->orderBy('id')
            ->get();
        return view('tenant.rooms.available', compact('rooms'));
    }

    /**
     * tenant view room details and booking page
     */
    public function bookRoom(Room $room)
    {
        if ($room->status !== 'available') {
            return redirect()->route('tenant.rooms')->with('error', 'This room is not available');
        }
        return view('tenant.rooms.book', compact('room'));
    }

    /**
     * tenant submit booking
     */
    public function storeBooking(Request $request, Room $room)
    {
        if ($room->status !== 'available') {
            return redirect()->route('tenant.rooms')->with('error', 'This room is not available');
        }

        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ], [
            'start_date.after_or_equal' => 'Check-in date cannot be earlier than today',
            'end_date.after' => 'Check-out date must be after check-in date',
        ]);

        // Calculate the number of days and the total price
        $startDate = new \DateTime($validated['start_date']);
        $endDate = new \DateTime($validated['end_date']);
        $days = $endDate->diff($startDate)->days;
        $totalPrice = $days * $room->price;

        // Create a booking
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        return redirect()->route('tenant.bookings.my')->with(
            'success',
            'Booking submitted, waiting for admin approval'
        );
    }

    /**
     * tenant view their own bookings
     */
    public function myBookings()
    {
        $bookings = Auth::user()->bookings()->with('room')->latest()->get();
        return view('tenant.bookings.my', compact('bookings'));
    }

    /**
     * tenant cancel booking
     */
    public function cancelBooking(Booking $booking)
    {
        // Check if the booking belongs to the current user
        if ($booking->user_id !== Auth::id()) {
            return redirect()->route('tenant.bookings.my')->with('error', 'No permission to perform this operation');
        }

        // Only pending bookings can be cancelled
        if ($booking->status !== 'pending') {
            return redirect()->route('tenant.bookings.my')->with('error', 'Only pending bookings can be cancelled');
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()->route('tenant.bookings.my')->with('success', 'Booking cancelled successfully');
    }

    /**
     * admin view all bookings
     */
    public function allBookings()
    {
        $bookings = Booking::with('user', 'room')
            ->orderBy('status')
            ->latest()
            ->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * admin approve booking
     */
    public function approveBooking(Booking $booking)
    {
        // 
        DB::transaction(function () use ($booking) {
            // update booking status
            $booking->update(['status' => 'active']);
            
            // update room status
            DB::table('rooms')
                ->where('id', $booking->room_id)
                ->update(['status' => 'rented', 'updated_at' => now()]);
        });

        return redirect()->route('admin.bookings.index')->with(
            'success',
            'Booking approved successfully, room status updated to rented'
        );
    }

    /**
     * admin reject booking
     */
    public function rejectBooking(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking rejected successfully');
    }

    /**
     * admin complete booking
     */
    public function completeBooking(Booking $booking)
    {
        // Prevent early completion: cannot complete the order if the check-out date has not arrived
        if ($booking->end_date->isFuture()) {
            return redirect()->route('admin.bookings.index')->with(
                'error',
                'The check-out date has not arrived, so the order cannot be completed yet'
            );
        }

        // Use transaction to ensure that both updates are successfully committed
        DB::transaction(function () use ($booking) {
            // update booking status
            $booking->update(['status' => 'completed']);
            
            // update room status
            DB::table('rooms')
                ->where('id', $booking->room_id)
                ->update(['status' => 'available', 'updated_at' => now()]);
        });

        return redirect()->route('admin.bookings.index')->with(
            'success',
            'Booking completed successfully, room status updated to available'
        );
    }
}
