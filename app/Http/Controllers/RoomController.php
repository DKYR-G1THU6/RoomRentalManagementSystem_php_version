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
        // 1. Get the latest room records from the database - ensure that the latest data is obtained every time
        $rooms = Room::latest()->get(); 
        
        // 2. Pass the data to the frontend view (write the path first, and we will create the view later)
        return view('rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
   {
        
        $validatedData = $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms,room_number', // required, unique room number
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0', // must be a number and cannot be negative
            'status' => 'required|in:available,rented,maintenance', // only these three states are allowed
            'description' => 'nullable|string', // optional
        ]);

        
        Room::create($validatedData);

        
        return redirect()->route('admin.rooms.index')->with('success', 'Room added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $room = Room::findOrFail($id);
        return view('rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $room = Room::findOrFail($id);
        return view('rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {        $room = Room::findOrFail($id);
                // 1. validate the input data
        // Note: the unique rule is appended with the current room id, meaning that the room number must be unique 
        // but it is allowed to be the same as the current room number
        $validatedData = $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms,room_number,' . $room->id,
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,rented,maintenance',
            'description' => 'nullable|string',
        ]);

        // 2. update database
        $room->update($validatedData);

        // 3. return to the list page with a success message
        return redirect()->route('admin.rooms.index')->with('success', 'Room information updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::findOrFail($id);
        
        // 1. delete the room
        $room->delete();

        // 2. return to the list page
        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully!');
    }
}
