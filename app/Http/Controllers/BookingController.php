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
     * Tenant views available rooms.
     */
    public function availableRooms(Request $request)
    {
        $this->authorize('viewAvailable', Room::class);

        $occupiedRoomIds = Booking::query()
            ->whereIn('status', ['active', 'completed'])
            ->whereDate('end_date', '>=', now()->toDateString())
            ->pluck('room_id');

        $search = trim((string) $request->query('q', ''));
        $type = $request->query('type');
        $priceMin = $request->query('price_min');
        $priceMax = $request->query('price_max');

        $query = Room::query()
            ->where('status', 'available')
            ->whereNotIn('id', $occupiedRoomIds)
            ->orderBy('id');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('room_number', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (is_string($type) && $type !== '') {
            $query->where('type', $type);
        }

        if (is_numeric($priceMin)) {
            $query->where('price', '>=', (float) $priceMin);
        }

        if (is_numeric($priceMax)) {
            $query->where('price', '<=', (float) $priceMax);
        }

        $rooms = $query->get();

        $roomTypes = Room::query()
            ->select('type')
            ->distinct()
            ->orderBy('type')
            ->pluck('type');

        return view('tenant.rooms.available', compact('rooms', 'roomTypes'));
    }

    /**
     * Tenant views a room booking page.
     */
    public function bookRoom(Room $room)
    {
        $this->authorize('book', $room);

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
        
        $this->authorize('create', Booking::class);
        $this->authorize('book', $room);

        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ], [
            'start_date.after_or_equal' => 'Check-in date cannot be earlier than today.',
            'end_date.after' => 'Check-out date must be later than the check-in date.',
        ]);

        $startDate = new \DateTime($validated['start_date']);
        $endDate = new \DateTime($validated['end_date']);
        $days = $endDate->diff($startDate)->days;
        $totalPrice = $days * $room->price;

        Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        return redirect()->route('tenant.bookings.my')->with(
            'success',
            'Booking submitted successfully and is waiting for admin approval.'
        );
    }

    /**
     * Tenant views their own bookings.
     */
    public function myBookings()
    {
        $this->authorize('viewAny', Booking::class);

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

        $this->authorize('cancel', $booking);

        $booking->update(['status' => 'cancelled']);

        return redirect()->route('tenant.bookings.my')->with('success', 'Booking cancelled successfully.');
    }

    /**
     * Admin views all bookings.
     */
    public function allBookings(Request $request)
    {
        $this->authorize('viewAdminList', Booking::class);

        $search = trim((string) $request->query('q', ''));
        $status = $request->query('status');
        $roomType = $request->query('room_type');
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');
        $priceMin = $request->query('price_min');
        $priceMax = $request->query('price_max');

        $query = Booking::query()->with('user', 'room');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('room', function ($rq) use ($search) {
                    $rq->where('room_number', 'like', "%{$search}%")
                        ->orWhere('type', 'like', "%{$search}%");
                });
            });
        }

        if (in_array($status, ['pending', 'active', 'completed', 'cancelled'], true)) {
            $query->where('status', $status);
        }

        if (is_string($roomType) && $roomType !== '') {
            $query->whereHas('room', function ($q) use ($roomType) {
                $q->where('type', $roomType);
            });
        }

        if (is_string($dateFrom) && $dateFrom !== '') {
            $query->whereDate('start_date', '>=', $dateFrom);
        }

        if (is_string($dateTo) && $dateTo !== '') {
            $query->whereDate('end_date', '<=', $dateTo);
        }

        if (is_numeric($priceMin)) {
            $query->where('total_price', '>=', (float) $priceMin);
        }

        if (is_numeric($priceMax)) {
            $query->where('total_price', '<=', (float) $priceMax);
        }

        $bookings = $query->orderBy('status')->latest()->get();

        $roomTypes = Room::query()
            ->select('type')
            ->distinct()
            ->orderBy('type')
            ->pluck('type');

        return view('admin.bookings.index', compact('bookings', 'roomTypes'));
    }

    /**
     * Admin approves a pending booking.
     */
    public function approveBooking(Booking $booking)
    {
        $this->authorize('approve', $booking);

        DB::transaction(function () use ($booking) {
            $booking->update(['status' => 'active']);

            DB::table('rooms')
                ->where('id', $booking->room_id)
                ->update(['status' => 'rented', 'updated_at' => now()]);
        });

        return redirect()->route('admin.bookings.index')->with(
            'success',
            'Booking approved and room status updated to rented.'
        );
    }

    /**
     * Admin rejects a pending booking.
     */
    public function rejectBooking(Booking $booking)
    {
        $this->authorize('reject', $booking);

        $booking->update(['status' => 'cancelled']);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking rejected successfully.');
    }

    /**
     * Admin completes an active booking.
     */
    public function completeBooking(Booking $booking)
    {
        $this->authorize('complete', $booking);

        if ($booking->end_date->isFuture()) {
            return redirect()->route('admin.bookings.index')->with(
                'error',
                'The booking cannot be completed before the check-out date.'
            );
        }

        DB::transaction(function () use ($booking) {
            $booking->update(['status' => 'completed']);

            DB::table('rooms')
                ->where('id', $booking->room_id)
                ->update(['status' => 'available', 'updated_at' => now()]);
        });

        return redirect()->route('admin.bookings.index')->with(
            'success',
            'Booking completed and room status updated to available.'
        );
    }
}
