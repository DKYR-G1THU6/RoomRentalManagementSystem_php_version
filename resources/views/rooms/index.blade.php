@extends('layouts.app')

@section('title', 'Room Management - Room Rental Management System')

@section('content')
    <div class="rr-page-top rr-page-top-row rr-mb-20">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="rr-link-back">← Back to Dashboard</a>
        </div>
    </div>
    
    <div class="rr-page-top-row rr-mb-20 rr-mt-20">
        <h2 class="rr-page-title rr-page-title--tight rr-m-0">Room Management</h2>
        <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">Add New Room</a>
    </div>

    <form method="GET" action="{{ route('admin.rooms.index') }}" class="rr-filter-form">
        <div class="rr-filter-grid rr-filter-grid-rooms">
            <div>
                <label for="q" class="rr-filter-label">Search</label>
                <input id="q" name="q" type="text" value="{{ request('q') }}" placeholder="Room no / type / description" class="rr-filter-control">
            </div>

            <div>
                <label for="status" class="rr-filter-label">Status</label>
                <select id="status" name="status" class="rr-filter-control">
                    <option value="">All</option>
                    <option value="available" @selected(request('status') === 'available')>Available</option>
                    <option value="rented" @selected(request('status') === 'rented')>Rented</option>
                    <option value="maintenance" @selected(request('status') === 'maintenance')>Maintenance</option>
                </select>
            </div>

            <div>
                <label for="type" class="rr-filter-label">Type</label>
                <select id="type" name="type" class="rr-filter-control">
                    <option value="">All</option>
                    @foreach ($roomTypes as $roomType)
                        <option value="{{ $roomType }}" @selected(request('type') === $roomType)>{{ $roomType }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="active_booking" class="rr-filter-label">Active Booking</label>
                <select id="active_booking" name="active_booking" class="rr-filter-control">
                    <option value="">All</option>
                    <option value="1" @selected(request('active_booking') === '1')>Has Active</option>
                    <option value="0" @selected(request('active_booking') === '0')>No Active</option>
                </select>
            </div>

            <div class="rr-flex-gap-10">
                <div class="rr-flex-1">
                    <label for="price_min" class="rr-filter-label">Min RM</label>
                    <input id="price_min" name="price_min" type="number" step="0.01" value="{{ request('price_min') }}" class="rr-filter-control">
                </div>
                <div class="rr-flex-1">
                    <label for="price_max" class="rr-filter-label">Max RM</label>
                    <input id="price_max" name="price_max" type="number" step="0.01" value="{{ request('price_max') }}" class="rr-filter-control">
                </div>
                <div class="rr-filter-actions">
                    <button type="submit" class="btn btn-primary rr-btn-compact">Filter</button>
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
                            <a href="{{ route('admin.rooms.show', $room->id) }}" class="btn btn-primary rr-btn-table">View</a>
                            <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-warning rr-btn-table">Edit</a>
                            <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" class="rr-form-inline rr-inline" onsubmit="return confirm('Are you sure you want to delete this room?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger rr-btn-table">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="info-box rr-empty-box-center">
            <p class="rr-empty-text">No rooms found</p>
            <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">Add First Room</a>
        </div>
    @endif
@endsection
