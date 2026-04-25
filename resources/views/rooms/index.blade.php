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
