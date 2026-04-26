@extends('layouts.app')

@section('title', 'Add New Room - Room Rental Management System')

@section('content')
    <div class="room-create-top">
        <a href="{{ route('admin.rooms.index') }}" class="rr-link-back">← Back to List</a>
    </div>
    
    <h2 class="room-create-title">Add New Room</h2>
    
    <form action="{{ route('admin.rooms.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="room_number">Room Number <span class="profile-edit-form__required">*</span></label>
            <input 
                type="text" 
                id="room_number" 
                name="room_number" 
                value="{{ old('room_number') }}"
                placeholder="e.g. 101, 102, 201"
                required
            >
            @error('room_number')
                <span class="profile-edit-form__error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="type">Room Type <span class="profile-edit-form__required">*</span></label>
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
                <span class="profile-edit-form__error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="price">Price (RM) <span class="profile-edit-form__required">*</span></label>
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
                <span class="profile-edit-form__error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="status">Status <span class="profile-edit-form__required">*</span></label>
            <select id="status" name="status_display" disabled class="room-create-disabled">
                <option value="available">Available</option>
            </select>
            <input type="hidden" name="status" value="available">
            <p class="room-create-note">New rooms are set to Available by default. You can change the status later on the edit page.</p>
            @error('status')
                <span class="profile-edit-form__error">{{ $message }}</span>
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
                <span class="profile-edit-form__error">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="room-create-actions">
            <button type="submit" class="btn btn-primary">Add Room</button>
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection