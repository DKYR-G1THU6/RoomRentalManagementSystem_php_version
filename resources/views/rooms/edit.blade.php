@extends('layouts.app')

@section('title', 'Edit Room - ' . $room->room_number)

@section('content')
    <div class="rr-page-top">
        <a href="{{ route('admin.rooms.index') }}" class="rr-link-back">← Back to List</a>
    </div>
    
    <h2 class="rr-page-title rr-page-title--tight">Edit Room Information</h2>
    
    <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="room_number">Room Number <span class="rr-required">*</span></label>
            <input 
                type="text" 
                id="room_number" 
                name="room_number" 
                value="{{ old('room_number', $room->room_number) }}"
                required
            >
            @error('room_number')
                <span class="rr-field-error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="type">Room Type <span class="rr-required">*</span></label>
            <select id="type" name="type" required>
                <option value="">-- Select Room Type --</option>
                <option value="Single Room" {{ old('type', $room->type) === 'Single Room' ? 'selected' : '' }}>Single Room</option>
                <option value="Double Room" {{ old('type', $room->type) === 'Double Room' ? 'selected' : '' }}>Double Room</option>
                <option value="Triple Room" {{ old('type', $room->type) === 'Triple Room' ? 'selected' : '' }}>Triple Room</option>
                <option value="Quad Room" {{ old('type', $room->type) === 'Quad Room' ? 'selected' : '' }}>Quad Room</option>
                <option value="5-Person Room" {{ old('type', $room->type) === '5-Person Room' ? 'selected' : '' }}>5-Person Room</option>
                <option value="Suite" {{ old('type', $room->type) === 'Suite' ? 'selected' : '' }}>Suite</option>
            </select>
            @error('type')
                <span class="rr-field-error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="price">Price (RM) <span class="rr-required">*</span></label>
            <input 
                type="number" 
                id="price" 
                name="price" 
                value="{{ old('price', $room->price) }}"
                step="0.01"
                min="0"
                required
            >
            @error('price')
                <span class="rr-field-error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="status">Status <span class="rr-required">*</span></label>
            <select id="status" name="status" required>
                <option value="available" {{ old('status', $room->status) === 'available' ? 'selected' : '' }}>Available</option>
                <option value="rented" {{ old('status', $room->status) === 'rented' ? 'selected' : '' }}>Rented</option>
                <option value="maintenance" {{ old('status', $room->status) === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
            </select>
            @error('status')
                <span class="rr-field-error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="description">Description</label>
            <textarea 
                id="description" 
                name="description" 
                placeholder="Enter room description (optional)"
            >{{ old('description', $room->description) }}</textarea>
            @error('description')
                <span class="rr-field-error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="rr-actions-row">
            <button type="submit" class="btn btn-primary rr-btn-room-form">Save Changes</button>
            <a href="{{ route('admin.rooms.show', $room->id) }}" class="btn btn-secondary rr-btn-room-form rr-link-no-underline">Cancel</a>
        </div>
    </form>
@endsection
