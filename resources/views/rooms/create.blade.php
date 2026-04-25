@extends('layouts.app')

@section('title', 'Add New Room - Room Rental Management System')

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.rooms.index') }}" style="color: #3498db; text-decoration: none;">← Back to List</a>
    </div>
    
    <h2 style="font-size: 24px; color: #2c3e50; margin-bottom: 30px;">Add New Room</h2>
    
    <form action="{{ route('admin.rooms.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="room_number">Room Number <span style="color: #e74c3c;">*</span></label>
            <input 
                type="text" 
                id="room_number" 
                name="room_number" 
                value="{{ old('room_number') }}"
                placeholder="e.g. 101, 102, 201"
                required
            >
            @error('room_number')
                <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="type">Room Type <span style="color: #e74c3c;">*</span></label>
            <select id="type" name="type" required>
                <option value="">-- Select Room Type --</option>
                <option value="Single Room" {{ old('type') === 'Single Room' ? 'selected' : '' }}>Single Room</option>
                <option value="Double Room" {{ old('type') === 'Double Room' ? 'selected' : '' }}>Double Room</option>
                <option value="Triple Room" {{ old('type') === 'Triple Room' ? 'selected' : '' }}>Triple Room</option>
                <option value="Quad Room" {{ old('type') === 'Quad Room' ? 'selected' : '' }}>Quad Room</option>
                <option value="5-Person Room" {{ old('type') === '5-Person Room' ? 'selected' : '' }}>5-Person Room</option>
                <option value="Suite" {{ old('type') === 'Suite' ? 'selected' : '' }}>Suite</option>
            </select>
            @error('type')
                <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="price">Price (RM) <span style="color: #e74c3c;">*</span></label>
            <input 
                type="number" 
                id="price" 
                name="price" 
                value="{{ old('price') }}"
                step="0.01"
                min="0"
                placeholder="e.g. 288.00"
                required
            >
            @error('price')
                <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="status">Status <span style="color: #e74c3c;">*</span></label>
            <select id="status" name="status_display" disabled style="background-color: #ecf0f1; cursor: not-allowed;">
                <option value="available">Available</option>
            </select>
            <input type="hidden" name="status" value="available">
            <p style="font-size: 12px; color: #7f8c8d; margin-top: 5px;">New rooms are set to Available by default. You can change the status later on the edit page.</p>
            @error('status')
                <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="description">Description</label>
            <textarea 
                id="description" 
                name="description" 
                placeholder="Enter room description (optional)"
            >{{ old('description') }}</textarea>
            @error('description')
                <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 15px; font-weight: 600;">Add Room</button>
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary" style="padding: 12px 30px; font-size: 15px; font-weight: 600; text-decoration: none;">Cancel</a>
        </div>
    </form>
@endsection