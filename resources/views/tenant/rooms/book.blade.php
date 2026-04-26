@extends('layouts.app')

@section('title', 'Book Room - ' . $room->room_number)

@section('content')
    <div class="rr-tenant-welcome">
        <h2 class="rr-page-title-lg">Book Room #{{ $room->room_number }}</h2>
    </div>
    
    <div class="tenant-book-layout">
        <!-- Room Information Card -->
        <div class="tenant-book-info rr-card">
            <div class="tenant-room-card-header rr-p-25">
                <h3 class="tenant-book-header-title">Room Information</h3>
            </div>
            
            <div class="tenant-room-card-body rr-p-25">
                <div class="tenant-book-section">
                    <p class="tenant-room-meta-label">Room Number</p>
                    <p class="tenant-book-value tenant-book-value-strong">#{{ $room->room_number }}</p>
                </div>
                
                <div class="tenant-book-section">
                    <p class="tenant-room-meta-label">Room Type</p>
                    <p class="tenant-book-value">{{ $room->type }}</p>
                </div>
                
                <div class="tenant-book-section">
                    <p class="tenant-room-meta-label">Price Per Night</p>
                    <p class="tenant-book-price">RM{{ number_format($room->price, 2) }}</p>
                </div>
                
                @if ($room->description)
                    <div class="tenant-book-section">
                        <p class="tenant-room-meta-label">Room Description</p>
                        <p class="tenant-room-desc">{{ $room->description }}</p>
                    </div>
                @endif
                
                <div>
                    <p class="tenant-room-meta-label">Status</p>
                    <span class="rr-status-pill rr-status-pill--active">Available</span>
                </div>
            </div>
        </div>
        
        <!-- Booking Form -->
        <div class="rr-card rr-p-25">
            <h3 class="tenant-book-form-title">Booking Details</h3>
            
            <form action="{{ route('tenant.store-booking', $room->id) }}" method="POST">
                @csrf
                
                <div class="tenant-book-section">
                    <label for="start_date" class="profile-edit-form__label">Check-in Date <span class="rr-required">*</span></label>
                    <input 
                        type="date" 
                        id="start_date" 
                        name="start_date" 
                        value="{{ old('start_date') }}"
                        min="{{ now()->format('Y-m-d') }}"
                        required
                        class="profile-edit-form__control"
                    >
                    @error('start_date')
                        <span class="rr-error-text">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="tenant-book-section">
                    <label for="end_date" class="profile-edit-form__label">Check-out Date <span class="rr-required">*</span></label>
                    <input 
                        type="date" 
                        id="end_date" 
                        name="end_date" 
                        value="{{ old('end_date') }}"
                        min="{{ now()->addDay()->format('Y-m-d') }}"
                        required
                        class="profile-edit-form__control"
                    >
                    @error('end_date')
                        <span class="rr-error-text">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="tenant-book-summary">
                    <div class="tenant-book-summary-row tenant-book-summary-row--split">
                        <span class="tenant-book-summary-label">Total Days</span>
                        <span id="days_count" class="tenant-book-days">-</span>
                    </div>
                    <div class="tenant-book-summary-row">
                        <span class="tenant-book-summary-label">Estimated Total</span>
                        <span id="total_price" class="tenant-book-total">RM0.00</span>
                    </div>
                </div>
                
                <button type="submit" class="rr-btn-apply rr-btn-lg rr-mb-12">Confirm Booking</button>
                <a href="{{ route('tenant.rooms') }}" class="rr-btn-cancel-link">Cancel</a>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const roomPrice = {{ $room->price }};
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const daysCount = document.getElementById('days_count');
        const totalPrice = document.getElementById('total_price');
        
        function calculatePrice() {
            if (startDateInput.value && endDateInput.value) {
                const start = new Date(startDateInput.value);
                const end = new Date(endDateInput.value);
                const diff = end - start;
                const days = Math.ceil(diff / (1000 * 60 * 60 * 24));
                
                if (days > 0) {
                    daysCount.textContent = days + ' days';
                    totalPrice.textContent = 'RM' + (days * roomPrice).toFixed(2);
                } else {
                    daysCount.textContent = '-';
                    totalPrice.textContent = 'RM0.00';
                }
            }
        }
        
        startDateInput.addEventListener('change', calculatePrice);
        endDateInput.addEventListener('change', calculatePrice);
    </script>
@endsection
