@extends('layouts.app')

@section('title', 'Booking Management')

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.dashboard') }}" style="color: #3498db; text-decoration: none;">← Back to Dashboard</a>
    </div>
    
    <h2 style="font-size: 24px; color: #2c3e50; margin-bottom: 30px;">Booking Management</h2>

    <form method="GET" action="{{ route('admin.bookings.index') }}" style="margin-bottom: 20px;">
        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr auto; gap: 10px; align-items: end;">
            <div>
                <label for="q" style="display:block; font-size: 12px; color: #7f8c8d; margin-bottom: 6px;">Search</label>
                <input id="q" name="q" type="text" value="{{ request('q') }}" placeholder="Tenant / email / room no / type" style="width: 100%; padding: 10px; border: 1px solid #dfe6e9; border-radius: 6px;">
            </div>

            <div>
                <label for="status" style="display:block; font-size: 12px; color: #7f8c8d; margin-bottom: 6px;">Status</label>
                <select id="status" name="status" style="width: 100%; padding: 10px; border: 1px solid #dfe6e9; border-radius: 6px;">
                    <option value="">All</option>
                    <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                    <option value="active" @selected(request('status') === 'active')>Active</option>
                    <option value="completed" @selected(request('status') === 'completed')>Completed</option>
                    <option value="cancelled" @selected(request('status') === 'cancelled')>Cancelled</option>
                </select>
            </div>

            <div>
                <label for="room_type" style="display:block; font-size: 12px; color: #7f8c8d; margin-bottom: 6px;">Room Type</label>
                <select id="room_type" name="room_type" style="width: 100%; padding: 10px; border: 1px solid #dfe6e9; border-radius: 6px;">
                    <option value="">All</option>
                    @foreach ($roomTypes as $type)
                        <option value="{{ $type }}" @selected(request('room_type') === $type)>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="date_from" style="display:block; font-size: 12px; color: #7f8c8d; margin-bottom: 6px;">From</label>
                <input id="date_from" name="date_from" type="date" value="{{ request('date_from') }}" style="width: 100%; padding: 10px; border: 1px solid #dfe6e9; border-radius: 6px;">
            </div>

            <div>
                <label for="date_to" style="display:block; font-size: 12px; color: #7f8c8d; margin-bottom: 6px;">To</label>
                <input id="date_to" name="date_to" type="date" value="{{ request('date_to') }}" style="width: 100%; padding: 10px; border: 1px solid #dfe6e9; border-radius: 6px;">
            </div>

            <div>
                <label for="price_min" style="display:block; font-size: 12px; color: #7f8c8d; margin-bottom: 6px;">Min RM</label>
                <input id="price_min" name="price_min" type="number" step="0.01" value="{{ request('price_min') }}" style="width: 100%; padding: 10px; border: 1px solid #dfe6e9; border-radius: 6px;">
            </div>

            <div>
                <label for="price_max" style="display:block; font-size: 12px; color: #7f8c8d; margin-bottom: 6px;">Max RM</label>
                <input id="price_max" name="price_max" type="number" step="0.01" value="{{ request('price_max') }}" style="width: 100%; padding: 10px; border: 1px solid #dfe6e9; border-radius: 6px;">
            </div>

            <div>
                <button type="submit" class="btn btn-primary" style="padding: 10px 14px;">Filter</button>
            </div>
        </div>
    </form>
    
    @php
        $pendingBookings = $bookings->where('status', 'pending');
        $activeBookings = $bookings->where('status', 'active');
        $completedBookings = $bookings->where('status', 'completed');
        $cancelledBookings = $bookings->where('status', 'cancelled');
    @endphp
    
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 30px;">
        <div style="background: #fff3cd; padding: 15px; border-radius: 8px; border-left: 4px solid #f39c12;">
            <div style="font-size: 24px; font-weight: bold; color: #f39c12;">{{ $pendingBookings->count() }}</div>
            <div style="color: #7f8c8d; margin-top: 5px; font-size: 12px;">Pending</div>
        </div>
        
        <div style="background: #d4edda; padding: 15px; border-radius: 8px; border-left: 4px solid #28a745;">
            <div style="font-size: 24px; font-weight: bold; color: #28a745;">{{ $activeBookings->count() }}</div>
            <div style="color: #7f8c8d; margin-top: 5px; font-size: 12px;">Active</div>
        </div>
        
        <div style="background: #d1ecf1; padding: 15px; border-radius: 8px; border-left: 4px solid #017a8c;">
            <div style="font-size: 24px; font-weight: bold; color: #017a8c;">{{ $completedBookings->count() }}</div>
            <div style="color: #7f8c8d; margin-top: 5px; font-size: 12px;">Completed</div>
        </div>
        
        <div style="background: #f8d7da; padding: 15px; border-radius: 8px; border-left: 4px solid #e74c3c;">
            <div style="font-size: 24px; font-weight: bold; color: #e74c3c;">{{ $cancelledBookings->count() }}</div>
            <div style="color: #7f8c8d; margin-top: 5px; font-size: 12px;">Cancelled</div>
        </div>
    </div>
    
    @if ($pendingBookings->count() > 0)
        <h3 style="color: #2c3e50; margin-bottom: 20px; margin-top: 40px;">Pending Bookings ({{ $pendingBookings->count() }})</h3>
        <table style="margin-bottom: 40px;">
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
                        <td><strong>#{{ $booking->room->room_number }}</strong></td>
                        <td>{{ $booking->room->type }}</td>
                        <td>{{ $booking->start_date->format('Y-m-d') }}</td>
                        <td>{{ $booking->end_date->format('Y-m-d') }}</td>
                        <td style="font-weight: bold; color: #27ae60;">RM{{ number_format($booking->total_price, 2) }}</td>
                        <td style="display: flex; gap: 8px;">
                            <form action="{{ route('admin.bookings.approve', $booking->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary" style="padding: 6px 12px; font-size: 12px; background-color: #27ae60; border: none; color: white; border-radius: 4px; cursor: pointer; font-weight: 600; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#229954';" onmouseout="this.style.backgroundColor='#27ae60';">Approve</button>
                            </form>
                            <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 12px; background-color: #e74c3c; border: none; color: white; border-radius: 4px; cursor: pointer; font-weight: 600; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#c0392b';" onmouseout="this.style.backgroundColor='#e74c3c';">Reject</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
    @if ($activeBookings->count() > 0)
        <h3 style="color: #2c3e50; margin-bottom: 20px;">Active Bookings ({{ $activeBookings->count() }})</h3>
        <table style="margin-bottom: 40px;">
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
                        <td>#{{ $booking->room->room_number }}</td>
                        <td>{{ $booking->room->type }}</td>
                        <td>{{ $booking->start_date->format('Y-m-d') }}</td>
                        <td>{{ $booking->end_date->format('Y-m-d') }}</td>
                        <td>RM{{ number_format($booking->total_price, 2) }}</td>
                        <td>
                            <form action="{{ route('admin.bookings.complete', $booking->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary" style="padding: 6px 12px; font-size: 12px; background-color: #667eea; border: none; color: white; border-radius: 4px; cursor: pointer; font-weight: 600; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#5568d3';" onmouseout="this.style.backgroundColor='#667eea';">Complete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
    @if ($completedBookings->count() > 0)
        <h3 style="color: #2c3e50; margin-bottom: 20px;">Completed Bookings ({{ $completedBookings->count() }})</h3>
        <table style="margin-bottom: 40px;">
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
                        <td>#{{ $booking->room->room_number }}</td>
                        <td>{{ $booking->room->type }}</td>
                        <td>{{ $booking->start_date->format('Y-m-d') }}</td>
                        <td>{{ $booking->end_date->format('Y-m-d') }}</td>
                        <td>RM{{ number_format($booking->total_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection

@section('css')
    <style>
        table form {
            display: inline;
            padding: 0;
            box-shadow: none;
            background: transparent;
        }
    </style>
@endsection
