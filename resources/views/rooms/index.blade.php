@extends('layouts.app')

@section('title', 'Room Management - Room Rental Management System')

@section('content')
    <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <a href="{{ route('admin.dashboard') }}" style="color: #3498db; text-decoration: none;">← Back to Dashboard</a>
        </div>
    </div>
    
    <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
        <h2 style="font-size: 24px; color: #2c3e50; margin: 0;">Room Management</h2>
        <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">Add New Room</a>
    </div>

    <form method="GET" action="{{ route('admin.rooms.index') }}" style="margin-bottom: 20px;">
        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr; gap: 10px; align-items: end;">
            <div>
                <label for="q" style="display:block; font-size: 12px; color: #7f8c8d; margin-bottom: 6px;">Search</label>
                <input id="q" name="q" type="text" value="{{ request('q') }}" placeholder="Room no / type / description" style="width: 100%; padding: 10px; border: 1px solid #dfe6e9; border-radius: 6px;">
            </div>

            <div>
                <label for="status" style="display:block; font-size: 12px; color: #7f8c8d; margin-bottom: 6px;">Status</label>
                <select id="status" name="status" style="width: 100%; padding: 10px; border: 1px solid #dfe6e9; border-radius: 6px;">
                    <option value="">All</option>
                    <option value="available" @selected(request('status') === 'available')>Available</option>
                    <option value="rented" @selected(request('status') === 'rented')>Rented</option>
                    <option value="maintenance" @selected(request('status') === 'maintenance')>Maintenance</option>
                </select>
            </div>

            <div>
                <label for="type" style="display:block; font-size: 12px; color: #7f8c8d; margin-bottom: 6px;">Type</label>
                <select id="type" name="type" style="width: 100%; padding: 10px; border: 1px solid #dfe6e9; border-radius: 6px;">
                    <option value="">All</option>
                    @foreach ($roomTypes as $roomType)
                        <option value="{{ $roomType }}" @selected(request('type') === $roomType)>{{ $roomType }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="active_booking" style="display:block; font-size: 12px; color: #7f8c8d; margin-bottom: 6px;">Active Booking</label>
                <select id="active_booking" name="active_booking" style="width: 100%; padding: 10px; border: 1px solid #dfe6e9; border-radius: 6px;">
                    <option value="">All</option>
                    <option value="1" @selected(request('active_booking') === '1')>Has Active</option>
                    <option value="0" @selected(request('active_booking') === '0')>No Active</option>
                </select>
            </div>

            <div style="display:flex; gap: 10px;">
                <div style="flex:1;">
                    <label for="price_min" style="display:block; font-size: 12px; color: #7f8c8d; margin-bottom: 6px;">Min RM</label>
                    <input id="price_min" name="price_min" type="number" step="0.01" value="{{ request('price_min') }}" style="width: 100%; padding: 10px; border: 1px solid #dfe6e9; border-radius: 6px;">
                </div>
                <div style="flex:1;">
                    <label for="price_max" style="display:block; font-size: 12px; color: #7f8c8d; margin-bottom: 6px;">Max RM</label>
                    <input id="price_max" name="price_max" type="number" step="0.01" value="{{ request('price_max') }}" style="width: 100%; padding: 10px; border: 1px solid #dfe6e9; border-radius: 6px;">
                </div>
                <div style="display:flex; align-items:end;">
                    <button type="submit" class="btn btn-primary" style="padding: 10px 14px;">Filter</button>
                </div>
            </div>
        </div>
    </form>
    
    @if ($rooms->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Room No.</th>
                    <th>Type</th>
                    <th>Price (RM)</th>
                    <th>Status</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rooms as $room)
                    <tr>
                        <td><strong>#{{ $room->room_number }}</strong></td>
                        <td>{{ $room->type }}</td>
                        <td><strong>RM{{ number_format($room->price, 2) }}</strong></td>
                        <td>
                            @if ($room->status === 'available')
                                <span class="badge badge-available">Available</span>
                            @elseif ($room->status === 'rented')
                                <span class="badge badge-rented">Rented</span>
                            @else
                                <span class="badge badge-maintenance">Maintenance</span>
                            @endif
                        </td>
                        <td>{{ Str::limit($room->description, 30, '...') }}</td>
                        <td>
                            <a href="{{ route('admin.rooms.show', $room->id) }}" class="btn btn-primary" style="padding: 6px 10px; font-size: 12px;">View</a>
                            <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-warning" style="padding: 6px 10px; font-size: 12px;">Edit</a>
                            <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this room?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 6px 10px; font-size: 12px;">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="info-box" style="text-align: center; padding: 60px 30px;">
            <p style="font-size: 16px; color: #7f8c8d; margin-bottom: 20px;">No rooms found</p>
            <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">Add First Room</a>
        </div>
    @endif
@endsection

@section('css')
    <style>
        table form {
            display: inline;
            padding: 0;
            box-shadow: none;
            background: transparent;
        }
        
        table .btn {
            margin: 0;
            padding: 6px 10px;
            font-size: 12px;
        }
    </style>
@endsection
