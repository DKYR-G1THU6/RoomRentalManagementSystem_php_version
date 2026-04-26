@extends('layouts.app')

@section('title', 'Booking Management')

@section('content')
    <div class="rr-page-top">
        <a href="{{ route('admin.dashboard') }}" class="rr-link-back">← Back to Dashboard</a>
    </div>

    <h2 class="rr-page-title rr-page-title--tight">Booking Management</h2>

    <form method="GET" action="{{ route('admin.bookings.index') }}" class="rr-filter-grid rr-filter-grid-bookings">
        <div>
            <label for="q" class="rr-filter-label">Search</label>
            <input id="q" name="q" type="text" value="{{ request('q') }}" placeholder="Tenant / email / room no / type" class="rr-filter-control">
        </div>

        <div>
            <label for="status" class="rr-filter-label">Status</label>
            <select id="status" name="status" class="rr-filter-control">
                <option value="">All</option>
                <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                <option value="active" @selected(request('status') === 'active')>Active</option>
                <option value="completed" @selected(request('status') === 'completed')>Completed</option>
                <option value="cancelled" @selected(request('status') === 'cancelled')>Cancelled</option>
            </select>
        </div>

        <div>
            <label for="room_type" class="rr-filter-label">Room Type</label>
            <select id="room_type" name="room_type" class="rr-filter-control">
                <option value="">All</option>
                @foreach ($roomTypes as $type)
                    <option value="{{ $type }}" @selected(request('room_type') === $type)>{{ $type }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="date_from" class="rr-filter-label">From</label>
            <input id="date_from" name="date_from" type="date" value="{{ request('date_from') }}" class="rr-filter-control">
        </div>

        <div>
            <label for="date_to" class="rr-filter-label">To</label>
            <input id="date_to" name="date_to" type="date" value="{{ request('date_to') }}" class="rr-filter-control">
        </div>

        <div>
            <label for="price_min" class="rr-filter-label">Min RM</label>
            <input id="price_min" name="price_min" type="number" step="0.01" value="{{ request('price_min') }}" class="rr-filter-control">
        </div>

        <div>
            <label for="price_max" class="rr-filter-label">Max RM</label>
            <input id="price_max" name="price_max" type="number" step="0.01" value="{{ request('price_max') }}" class="rr-filter-control">
        </div>

        <div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    @php
        $pendingBookings = $bookings->where('status', 'pending');
        $activeBookings = $bookings->where('status', 'active');
        $completedBookings = $bookings->where('status', 'completed');
        $cancelledBookings = $bookings->where('status', 'cancelled');
    @endphp

    <div class="rr-grid-4">
        <div class="rr-summary-card rr-summary-card--pending">
            <div class="rr-summary-card__value">{{ $pendingBookings->count() }}</div>
            <div class="rr-summary-card__label">Pending</div>
        </div>

        <div class="rr-summary-card rr-summary-card--active">
            <div class="rr-summary-card__value">{{ $activeBookings->count() }}</div>
            <div class="rr-summary-card__label">Active</div>
        </div>

        <div class="rr-summary-card rr-summary-card--completed">
            <div class="rr-summary-card__value">{{ $completedBookings->count() }}</div>
            <div class="rr-summary-card__label">Completed</div>
        </div>

        <div class="rr-summary-card rr-summary-card--cancelled">
            <div class="rr-summary-card__value">{{ $cancelledBookings->count() }}</div>
            <div class="rr-summary-card__label">Cancelled</div>
        </div>
    </div>

    @if ($pendingBookings->count() > 0)
        <h3 class="rr-panel__title rr-panel__title--tight">Pending Bookings ({{ $pendingBookings->count() }})</h3>
        <table class="rr-table-spaced">
            <thead>
                <tr>
                    <th>Tenant</th>
                    <th>Contact</th>
                    <th>Room</th>
                    <th>Room Type</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendingBookings as $booking)
                    <tr>
                        <td><strong>{{ $booking->user->name }}</strong></td>
                        <td>{{ $booking->user->email }}</td>
                        <td><strong>{{ $booking->room?->room_number ? '#' . $booking->room->room_number : '—' }}</strong></td>
                        <td>{{ $booking->room?->type ?? '—' }}</td>
                        <td>{{ $booking->start_date->format('Y-m-d') }}</td>
                        <td>{{ $booking->end_date->format('Y-m-d') }}</td>
                        <td class="rr-price">RM{{ number_format($booking->total_price, 2) }}</td>
                        <td class="rr-table-actions">
                            <form action="{{ route('admin.bookings.approve', $booking->id) }}" method="POST" class="rr-form-inline">
                                @csrf
                                <button type="submit" class="btn rr-btn-xs rr-btn-approve">Approve</button>
                            </form>
                            <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST" class="rr-form-inline">
                                @csrf
                                <button type="submit" class="btn rr-btn-xs rr-btn-reject">Reject</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if ($activeBookings->count() > 0)
        <h3 class="rr-panel__title rr-panel__title--tight">Active Bookings ({{ $activeBookings->count() }})</h3>
        <table class="rr-table-spaced">
            <thead>
                <tr>
                    <th>Tenant</th>
                    <th>Room</th>
                    <th>Type</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activeBookings as $booking)
                    <tr>
                        <td>{{ $booking->user->name }}</td>
                        <td>{{ $booking->room?->room_number ? '#' . $booking->room->room_number : '—' }}</td>
                        <td>{{ $booking->room?->type ?? '—' }}</td>
                        <td>{{ $booking->start_date->format('Y-m-d') }}</td>
                        <td>{{ $booking->end_date->format('Y-m-d') }}</td>
                        <td>RM{{ number_format($booking->total_price, 2) }}</td>
                        <td class="rr-table-actions">
                            <form action="{{ route('admin.bookings.complete', $booking->id) }}" method="POST" class="rr-form-inline">
                                @csrf
                                <button type="submit" class="btn rr-btn-xs rr-btn-complete">Complete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if ($completedBookings->count() > 0)
        <h3 class="rr-panel__title rr-panel__title--tight">Completed Bookings ({{ $completedBookings->count() }})</h3>
        <table class="rr-table-spaced">
            <thead>
                <tr>
                    <th>Tenant</th>
                    <th>Room</th>
                    <th>Type</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($completedBookings->take(10) as $booking)
                    <tr>
                        <td>{{ $booking->user->name }}</td>
                        <td>{{ $booking->room?->room_number ? '#' . $booking->room->room_number : '—' }}</td>
                        <td>{{ $booking->room?->type ?? '—' }}</td>
                        <td>{{ $booking->start_date->format('Y-m-d') }}</td>
                        <td>{{ $booking->end_date->format('Y-m-d') }}</td>
                        <td>RM{{ number_format($booking->total_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
