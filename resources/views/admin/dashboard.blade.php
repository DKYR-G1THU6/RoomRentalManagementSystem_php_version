@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <h2 class="rr-page-title">Admin Dashboard</h2>

    <div class="rr-grid-6">
        <div class="rr-stat-card rr-stat-card--blue">
            <div class="rr-stat-card__value">{{ $stats['total_rooms'] }}</div>
            <div class="rr-stat-card__label">Total Rooms</div>
        </div>

        <div class="rr-stat-card rr-stat-card--green">
            <div class="rr-stat-card__value">{{ $stats['available_rooms'] }}</div>
            <div class="rr-stat-card__label">Available Rooms</div>
        </div>

        <div class="rr-stat-card rr-stat-card--orange">
            <div class="rr-stat-card__value">{{ $stats['rented_rooms'] }}</div>
            <div class="rr-stat-card__label">Rented Rooms</div>
        </div>

        <div class="rr-stat-card rr-stat-card--pink">
            <div class="rr-stat-card__value">{{ $stats['maintenance_rooms'] }}</div>
            <div class="rr-stat-card__label">Under Maintenance</div>
        </div>

        <div class="rr-stat-card rr-stat-card--purple">
            <div class="rr-stat-card__value">{{ $stats['total_tenants'] }}</div>
            <div class="rr-stat-card__label">Tenant Users</div>
        </div>

        <div class="rr-stat-card rr-stat-card--teal">
            <div class="rr-stat-card__value">{{ $stats['pending_bookings'] }}</div>
            <div class="rr-stat-card__label">Pending Bookings</div>
        </div>
    </div>

    <div class="rr-grid-2">
        <div class="rr-panel">
            <div class="rr-panel__header">
                <h3 class="rr-panel__title">Quick Actions</h3>
            </div>
            <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary rr-btn-block">Add Room</a>
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-primary rr-btn-block">Manage Rooms</a>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-warning rr-btn-block">Manage Bookings</a>
            <a href="{{ route('admin.tenants') }}" class="btn btn-primary rr-btn-block">Manage Tenants</a>
        </div>

        <div class="rr-panel">
            <div class="rr-panel__header">
                <h3 class="rr-panel__title">Statistics</h3>
            </div>
            <div class="rr-stat-row">
                <div class="rr-stat-row__inner">
                    <span class="rr-stat-row__label">Total Bookings</span>
                    <strong class="rr-stat-row__value rr-stat-row__value--dark">{{ $stats['total_bookings'] }}</strong>
                </div>
            </div>
            <div class="rr-stat-row">
                <div class="rr-stat-row__inner">
                    <span class="rr-stat-row__label">Active Bookings</span>
                    <strong class="rr-stat-row__value rr-stat-row__value--green">{{ $stats['active_bookings'] }}</strong>
                </div>
            </div>
            <div class="rr-stat-row">
                <div class="rr-stat-row__inner">
                    <span class="rr-stat-row__label">Occupancy Rate</span>
                    <strong class="rr-stat-row__value rr-stat-row__value--dark">
                        @php
                            $occupancy = $stats['total_rooms'] > 0 ? round(($stats['rented_rooms'] / $stats['total_rooms']) * 100) : 0;
                        @endphp
                        {{ $occupancy }}%
                    </strong>
                </div>
            </div>
        </div>
    </div>
    
    @if ($pendingBookings->count() > 0)
        <h3 class="rr-panel__title rr-panel__title--tight">Pending Bookings ({{ $pendingBookings->count() }})</h3>
        <table class="rr-table-spaced">
            <thead>
                <tr>
                    <th>Tenant</th>
                    <th>Room</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendingBookings as $booking)
                    <tr>
                        <td>{{ $booking->user->name }}</td>
                        <td>{{ $booking->room?->room_number ? '#' . $booking->room->room_number : '—' }}</td>
                        <td>{{ $booking->start_date->format('Y-m-d') }}</td>
                        <td>{{ $booking->end_date->format('Y-m-d') }}</td>
                        <td>RM{{ number_format($booking->total_price, 2) }}</td>
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
    
    <h3 class="rr-panel__title rr-panel__title--tight">Recent Bookings</h3>
    <table>
        <thead>
            <tr>
                <th>Tenant</th>
                <th>Room</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Total Price</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($recentBookings as $booking)
                <tr>
                    <td>{{ $booking->user->name }}</td>
                    <td>{{ $booking->room?->room_number ? '#' . $booking->room->room_number : '—' }}</td>
                    <td>{{ $booking->start_date->format('Y-m-d') }}</td>
                    <td>{{ $booking->end_date->format('Y-m-d') }}</td>
                    <td>RM{{ number_format($booking->total_price, 2) }}</td>
                    <td>
                        @if ($booking->status === 'pending')
                            <span class="badge rr-status-pill rr-status-pill--pending">Pending</span>
                        @elseif ($booking->status === 'active')
                            <span class="badge rr-status-pill rr-status-pill--active">Active</span>
                        @elseif ($booking->status === 'completed')
                            <span class="badge rr-status-pill rr-status-pill--completed">Completed</span>
                        @else
                            <span class="badge rr-status-pill rr-status-pill--cancelled">Cancelled</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
