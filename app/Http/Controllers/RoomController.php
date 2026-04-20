<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Room::class);

        $rooms = Room::latest()->get();

        return view('rooms.index', compact('rooms'));
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

        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully!');
    }
}
