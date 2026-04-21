@extends('layouts.app')

@section('title', '房间详情 - ' . $room->room_number)

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.rooms.index') }}" style="color: #3498db; text-decoration: none;">← Back to List</a>
    </div>
    
    <h2 style="font-size: 24px; color: #2c3e50; margin-bottom: 20px;">Room Details</h2>
    
    <div class="info-box">
        <div class="info-row">
            <div class="info-label">Room Number</div>
            <div class="info-value"><strong>#{{ $room->room_number }}</strong></div>
        </div>
        
        <div class="info-row">
            <div class="info-label">Room Type</div>
            <div class="info-value">{{ $room->type }}</div>
        </div>
        
        <div class="info-row">
            <div class="info-label">Price</div>
            <div class="info-value"><strong>RM{{ number_format($room->price, 2) }}</strong> / night</div>
        </div>
        
        <div class="info-row">
            <div class="info-label">Status</div>
            <div class="info-value">
                @if ($room->status === 'available')
                    <span class="badge badge-available">✓ Available</span>
                @elseif ($room->status === 'rented')
                    <span class="badge badge-rented">✗ Rented</span>
                @else
                    <span class="badge badge-maintenance">⚙ Maintenance</span>
                @endif
            </div>
        </div>
        
        <div class="info-row">
            <div class="info-label">Description</div>
            <div class="info-value">
                @if ($room->description)
                    {{ $room->description }}
                @else
                    <em style="color: #bdc3c7;">No description</em>
                @endif
            </div>
        </div>
        
        <div class="info-row">
            <div class="info-label">Created At</div>
            <div class="info-value">{{ $room->created_at->format('Y-m-d H:i') }}</div>
        </div>
        
        <div class="info-row">
            <div class="info-label">Last Modified</div>
            <div class="info-value">{{ $room->updated_at->format('Y-m-d H:i') }}</div>
        </div>
    </div>
    
    <div class="actions">
        <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-warning">✏️ Edit Room</a>
        
        <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this room?');">🗑️ Delete Room</button>
        </form>
        
        <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">← Back to List</a>
    </div>
@endsection

@section('css')
    <style>
        .actions form {
            display: inline;
            padding: 0;
            box-shadow: none;
            background: transparent;
            margin: 0;
        }
    </style>
@endsection
