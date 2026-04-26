<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{ 
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Room::class);

        $query = Room::query();

        $search = trim((string) $request->query('q', ''));
        $status = $request->query('status');
        $type = $request->query('type');
        $priceMin = $request->query('price_min');
        $priceMax = $request->query('price_max');
        $activeBooking = $request->query('active_booking');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('room_number', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (in_array($status, ['available', 'rented', 'maintenance'], true)) {
            $query->where('status', $status);
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

        // Relational filtering demo: rooms that have (or don't have) active bookings.
        if ($activeBooking === '1') {
            $query->whereHas('bookings', function ($q) {
                $q->where('status', 'active');
            });
        } elseif ($activeBooking === '0') {
            $query->whereDoesntHave('bookings', function ($q) {
                $q->where('status', 'active');
            });
        }

        $rooms = $query->latest()->get();

        $roomTypes = Room::query()
            ->select('type')
            ->distinct()
            ->orderBy('type')
            ->pluck('type');

        return view('rooms.index', compact('rooms', 'roomTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Room::class);

        return view('rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Room::class);

        $validatedData = $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms,room_number',
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,rented,maintenance',
            'description' => 'nullable|string',
        ]);

        Room::create($validatedData);

        return redirect()->route('admin.rooms.index')->with('success', 'Add Room Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $room = Room::findOrFail($id);
        $this->authorize('view', $room);

        return view('rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $room = Room::findOrFail($id);
        $this->authorize('update', $room);

        return view('rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $room = Room::findOrFail($id);
        $this->authorize('update', $room);

        $validatedData = $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms,room_number,' . $room->id,
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,rented,maintenance',
            'description' => 'nullable|string',
        ]);

        $room->update($validatedData);

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::findOrFail($id);
        $this->authorize('delete', $room);

        if ($room->bookings()->exists()) {
            return redirect()
                ->route('admin.rooms.index')
                ->with('error', 'Cannot delete this room because it has booking records. Consider marking it as maintenance instead.');
        }

        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully!');
    }
}
