@extends('layouts.app')

@section('title', 'Browse Available Rooms')

@section('content')
    <div class="rr-tenant-welcome">
        <h2 class="rr-page-title-lg">Browse Available Rooms</h2>
        <p class="rr-page-subtitle">Choose a room to make a booking</p>
    </div>

    <div class="tenant-room-layout">
        <aside class="tenant-room-filters" aria-label="Room filters">
            <div class="rr-card rr-card-p-18">
                <div class="tenant-room-filter-header">
                    <h3 class="tenant-room-filter-title">Filter</h3>
                    <a href="{{ route('tenant.rooms') }}" class="tenant-room-reset">Reset</a>
                </div>

                <form method="GET" action="{{ route('tenant.rooms') }}">
                    <div class="tenant-room-field">
                        <label for="q" class="rr-filter-label">Search</label>
                        <input id="q" name="q" type="text" value="{{ request('q') }}" placeholder="Room no / type / description" class="rr-filter-control">
                    </div>

                    <div class="tenant-room-field">
                        <label for="type" class="rr-filter-label">Room Type</label>
                        <select id="type" name="type" class="rr-filter-control">
                            <option value="">All</option>
                            @foreach ($roomTypes as $roomType)
                                <option value="{{ $roomType }}" @selected(request('type') === $roomType)>{{ $roomType }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="tenant-room-price-grid">
                        <div>
                            <label for="price_min" class="rr-filter-label">Min RM</label>
                            <input id="price_min" name="price_min" type="number" step="0.01" min="0" value="{{ request('price_min') }}" class="rr-filter-control">
                        </div>
                        <div>
                            <label for="price_max" class="rr-filter-label">Max RM</label>
                            <input id="price_max" name="price_max" type="number" step="0.01" min="0" value="{{ request('price_max') }}" class="rr-filter-control">
                        </div>
                    </div>

                    <button type="submit" class="rr-btn-apply">Apply</button>
                </form>
            </div>
        </aside>

        <section class="tenant-room-results" aria-label="Available rooms">
            @if ($rooms->count() > 0)
                <div class="tenant-room-scroll">
                    <div class="room-grid">
                        @foreach ($rooms as $room)
                            <div class="tenant-room-card">
                                <div class="tenant-room-card-header">
                                    <div class="tenant-room-card-header-row">
                                        <div>
                                            <h3 class="tenant-room-card-title">Room #{{ $room->room_number }}</h3>
                                            <p class="tenant-room-card-type">{{ $room->type }}</p>
                                        </div>
                                        <div class="welcome-feature-icon"></div>
                                    </div>
                                </div>
                                
                                <div class="tenant-room-card-body">
                                    <div class="tenant-room-block">
                                        <p class="tenant-room-meta-label">Price Per Night</p>
                                        <p class="tenant-room-price">RM{{ number_format($room->price, 2) }}</p>
                                    </div>
                                    
                                    @if ($room->description)
                                        <div class="tenant-room-desc-block">
                                            <p class="tenant-room-meta-label">Room Description</p>
                                            <p class="tenant-room-desc">{{ $room->description }}</p>
                                        </div>
                                    @else
                                        <div class="tenant-room-desc-block">
                                            <p class="tenant-room-meta-label">Room Description</p>
                                            <p class="tenant-room-desc tenant-room-desc--empty">&nbsp;</p>
                                        </div>
                                    @endif
                                    
                                    <div class="tenant-room-status-row">
                                        <span class="rr-status-pill rr-status-pill--active">Available</span>
                                    </div>
                                    
                                    <a href="{{ route('tenant.book-room', $room->id) }}" class="rr-btn-book">Book This Room</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="rr-empty-state">
                    <p class="rr-empty-title">No available rooms at the moment</p>
                    <p class="rr-empty-subtitle">Please check back later</p>
                </div>
            @endif
        </section>
    </div>
@endsection
