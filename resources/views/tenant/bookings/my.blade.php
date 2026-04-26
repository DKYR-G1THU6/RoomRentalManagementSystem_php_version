@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')
    <div class="rr-tenant-welcome">
        <h2 class="booking-page-title">My Bookings</h2>
    </div>

    @if ($bookings->count() > 0)
        @php
            $bookingSections = [
                [
                    'title' => 'Pending Bookings',
                    'items' => $bookings->where('status', 'pending'),
                    'headerClass' => 'booking-section__header--pending',
                    'priceClass' => 'booking-price--pending',
                    'statusClass' => null,
                ],
                [
                    'title' => 'Active Bookings',
                    'items' => $bookings->where('status', 'active'),
                    'headerClass' => 'booking-section__header--active',
                    'priceClass' => 'booking-price--active',
                    'statusClass' => 'booking-status-pill--active',
                ],
                [
                    'title' => 'Completed Bookings',
                    'items' => $bookings->where('status', 'completed'),
                    'headerClass' => 'booking-section__header--completed',
                    'priceClass' => 'booking-price--completed',
                    'statusClass' => 'booking-status-pill--completed',
                ],
                [
                    'title' => 'Cancelled Bookings',
                    'items' => $bookings->where('status', 'cancelled'),
                    'headerClass' => 'booking-section__header--cancelled',
                    'priceClass' => 'booking-price--cancelled',
                    'statusClass' => 'booking-status-pill--cancelled',
                ],
            ];
        @endphp

        @foreach ($bookingSections as $section)
            @if ($section['items']->count() > 0)
                <div class="booking-section">
                    <div class="booking-section__header {{ $section['headerClass'] }}">
                        <h3 class="booking-section__title">{{ $section['title'] }}</h3>
                    </div>
                    <div class="booking-section__shell">
                        <table class="booking-table">
                            <thead>
                                <tr>
                                    <th>Room No.</th>
                                    <th>Type</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th class="is-right">Total Price</th>
                                    <th class="is-center">{{ $section['statusClass'] ? 'Status' : 'Action' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($section['items'] as $booking)
                                    <tr>
                                        <td class="is-strong">{{ $booking->room?->room_number ? '#' . $booking->room->room_number : '—' }}</td>
                                        <td>{{ $booking->room?->type ?? '—' }}</td>
                                        <td>{{ $booking->start_date->format('Y-m-d') }}</td>
                                        <td>{{ $booking->end_date->format('Y-m-d') }}</td>
                                        <td class="is-right {{ $section['priceClass'] }}">RM{{ number_format($booking->total_price, 2) }}</td>
                                        <td class="is-center">
                                            @if ($section['statusClass'])
                                                <span class="booking-status-pill {{ $section['statusClass'] }}">{{ ucfirst($booking->status) }}</span>
                                            @else
                                                <form action="{{ route('tenant.bookings.cancel', $booking->id) }}" method="POST" class="rr-inline-form" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="rr-btn-cancel rr-btn-xs">Cancel Booking</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <div class="booking-empty">
            <p class="booking-empty__title">No bookings yet</p>
            <p class="booking-empty__text">Start browsing available rooms and make a booking</p>
            <a href="{{ route('tenant.rooms') }}" class="btn btn-primary">Browse Available Rooms</a>
        </div>
    @endif
@endsection