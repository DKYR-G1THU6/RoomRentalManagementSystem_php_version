@extends('layouts.app')

@section('title', 'Tenant Dashboard')

@section('content')
    <div class="rr-tenant-welcome">
        <h2 class="rr-tenant-title">👤 Welcome back, {{ auth()->user()->name }}</h2>
        <p class="rr-tenant-subtitle">This is your personal rental management centre</p>
    </div>

    <div class="rr-kpi-grid">
        <div class="rr-kpi-card rr-kpi-card--blue">
            <div class="rr-kpi-card__inner">
                <div>
                    <p class="rr-kpi-card__label">Active Bookings</p>
                    <p class="rr-kpi-card__value">{{ $stats['active_bookings'] }}</p>
                </div>
                <div class="rr-kpi-card__icon">🏨</div>
            </div>
        </div>

        <div class="rr-kpi-card rr-kpi-card--orange">
            <div class="rr-kpi-card__inner">
                <div>
                    <p class="rr-kpi-card__label">Pending Bookings</p>
                    <p class="rr-kpi-card__value">{{ $stats['pending_bookings'] }}</p>
                </div>
                <div class="rr-kpi-card__icon">⏳</div>
            </div>
        </div>

        <div class="rr-kpi-card rr-kpi-card--green">
            <div class="rr-kpi-card__inner">
                <div>
                    <p class="rr-kpi-card__label">Completed Bookings</p>
                    <p class="rr-kpi-card__value">{{ $stats['completed_bookings'] }}</p>
                </div>
                <div class="rr-kpi-card__icon">✓</div>
            </div>
        </div>
    </div>

    <h3 class="rr-panel__title rr-panel__title--tight">Quick Actions</h3>
    <div class="rr-actions">
        <a href="{{ route('tenant.rooms') }}" class="rr-card-link">
            <div class="rr-action-card">
                <div class="rr-action-card__icon">🔍</div>
                <h4 class="rr-action-card__title">Browse Rooms</h4>
                <p class="rr-action-card__text">View all available rooms</p>
            </div>
        </a>

        <a href="{{ route('tenant.bookings.my') }}" class="rr-card-link">
            <div class="rr-action-card">
                <div class="rr-action-card__icon">📋</div>
                <h4 class="rr-action-card__title">My Bookings</h4>
                <p class="rr-action-card__text">View and manage your bookings</p>
            </div>
        </a>

        <a href="{{ route('profile.edit') }}" class="rr-card-link">
            <div class="rr-action-card">
                <div class="rr-action-card__icon">👤</div>
                <h4 class="rr-action-card__title">My Profile</h4>
                <p class="rr-action-card__text">Update account information</p>
            </div>
        </a>
    </div>

    @if ($bookings->count() > 0)
        <h3 class="rr-panel__title rr-panel__title--tight">📊 Recent Bookings</h3>
        <div class="rr-table-shell">
            <table>
                <thead>
                    <tr class="rr-table-header">
                        <th>Room No.</th>
                        <th>Room Type</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Total Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings->take(5) as $booking)
                        <tr class="rr-table-row">
                            <td><strong>{{ $booking->room?->room_number ? '#' . $booking->room->room_number : '—' }}</strong></td>
                            <td>{{ $booking->room?->type ?? '—' }}</td>
                            <td>{{ $booking->start_date->format('Y-m-d') }}</td>
                            <td>{{ $booking->end_date->format('Y-m-d') }}</td>
                            <td>RM{{ number_format($booking->total_price, 2) }}</td>
                            <td>
                                @if ($booking->status === 'pending')
                                    <span class="rr-status-pill rr-status-pill--pending">⏳ Pending</span>
                                @elseif ($booking->status === 'active')
                                    <span class="rr-status-pill rr-status-pill--active">🏨 Active</span>
                                @elseif ($booking->status === 'completed')
                                    <span class="rr-status-pill rr-status-pill--completed">✓ Completed</span>
                                @else
                                    <span class="rr-status-pill rr-status-pill--cancelled">✗ Cancelled</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="rr-link-center">
            <a href="{{ route('tenant.bookings.my') }}" class="rr-link-primary">View All Bookings →</a>
        </div>
    @else
        <div class="rr-empty-state">
            <p class="rr-empty-state__text">No bookings yet</p>
            <a href="{{ route('tenant.rooms') }}" class="btn btn-primary">Browse Rooms</a>
        </div>
    @endif
@endsection
