@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <h2 style="font-size: 28px; color: #2c3e50; margin-bottom: 30px;">👑 Admin Dashboard</h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 40px;">
        <div style="background: #e3f2fd; padding: 20px; border-radius: 8px; border-left: 4px solid #2196f3;">
            <div style="font-size: 28px; font-weight: bold; color: #2196f3;">{{ $stats['total_rooms'] }}</div>
            <div style="color: #7f8c8d; margin-top: 5px;">🏨 Total Rooms</div>
        </div>
        
        <div style="background: #e8f5e9; padding: 20px; border-radius: 8px; border-left: 4px solid #4caf50;">
            <div style="font-size: 28px; font-weight: bold; color: #4caf50;">{{ $stats['available_rooms'] }}</div>
            <div style="color: #7f8c8d; margin-top: 5px;">✓ Available Rooms</div>
        </div>
        
        <div style="background: #fff3e0; padding: 20px; border-radius: 8px; border-left: 4px solid #ff9800;">
            <div style="font-size: 28px; font-weight: bold; color: #ff9800;">{{ $stats['rented_rooms'] }}</div>
            <div style="color: #7f8c8d; margin-top: 5px;">🚪 Rented Rooms</div>
        </div>
        
        <div style="background: #fce4ec; padding: 20px; border-radius: 8px; border-left: 4px solid #e91e63;">
            <div style="font-size: 28px; font-weight: bold; color: #e91e63;">{{ $stats['maintenance_rooms'] }}</div>
            <div style="color: #7f8c8d; margin-top: 5px;">⚙️ Under Maintenance</div>
        </div>
        
        <div style="background: #f3e5f5; padding: 20px; border-radius: 8px; border-left: 4px solid #9c27b0;">
            <div style="font-size: 28px; font-weight: bold; color: #9c27b0;">{{ $stats['total_tenants'] }}</div>
            <div style="color: #7f8c8d; margin-top: 5px;">👥 Tenant Users</div>
        </div>
        
        <div style="background: #e0f2f1; padding: 20px; border-radius: 8px; border-left: 4px solid #009688;">
            <div style="font-size: 28px; font-weight: bold; color: #009688;">{{ $stats['pending_bookings'] }}</div>
            <div style="color: #7f8c8d; margin-top: 5px;">⏳ Pending Bookings</div>
        </div>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 40px;">
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="color: #2c3e50; margin: 0;">🔧 Quick Actions</h3>
            </div>
            <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary" style="width: 100%; margin-bottom: 10px; display: block; text-align: center; text-decoration: none;">➕ Add Room</a>
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-primary" style="width: 100%; margin-bottom: 10px; display: block; text-align: center; text-decoration: none;">🏨 Manage Rooms</a>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-warning" style="width: 100%; margin-bottom: 10px; display: block; text-align: center; text-decoration: none;">📋 Manage Bookings</a>
            <a href="{{ route('admin.tenants') }}" class="btn btn-primary" style="width: 100%; display: block; text-align: center; text-decoration: none;">👥 Manage Tenants</a>
        </div>
        
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="color: #2c3e50; margin: 0;">📊 Statistics</h3>
            </div>
            <div style="margin-bottom: 15px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #7f8c8d;">Total Bookings</span>
                    <strong style="color: #2c3e50;">{{ $stats['total_bookings'] }}</strong>
                </div>
            </div>
            <div style="margin-bottom: 15px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #7f8c8d;">Active Bookings</span>
                    <strong style="color: #27ae60;">{{ $stats['active_bookings'] }}</strong>
                </div>
            </div>
            <div style="margin-bottom: 15px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #7f8c8d;">Occupancy Rate</span>
                    <strong style="color: #2c3e50;">
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
        <h3 style="color: #2c3e50; margin-bottom: 20px;">⏳ Pending Bookings ({{ $pendingBookings->count() }})</h3>
        <table style="margin-bottom: 40px;">
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
                        <td>💼 {{ $booking->user->name }}</td>
                        <td>#{{ $booking->room->room_number }}</td>
                        <td>{{ $booking->start_date->format('Y-m-d') }}</td>
                        <td>{{ $booking->end_date->format('Y-m-d') }}</td>
                        <td>RM{{ number_format($booking->total_price, 2) }}</td>
                        <td>
                            <form action="{{ route('admin.bookings.approve', $booking->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary" style="padding: 6px 10px; font-size: 12px; margin-right: 5px;">✓ Approve</button>
                            </form>
                            <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger" style="padding: 6px 10px; font-size: 12px;">✗ Reject</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
    <h3 style="color: #2c3e50; margin-bottom: 20px;">📅 Recent Bookings</h3>
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
                    <td>#{{ $booking->room->room_number }}</td>
                    <td>{{ $booking->start_date->format('Y-m-d') }}</td>
                    <td>{{ $booking->end_date->format('Y-m-d') }}</td>
                    <td>RM{{ number_format($booking->total_price, 2) }}</td>
                    <td>
                        @if ($booking->status === 'pending')
                            <span class="badge" style="background-color: #fff3cd; color: #856404;">⏳ Pending</span>
                        @elseif ($booking->status === 'active')
                            <span class="badge badge-available">🏨 Active</span>
                        @elseif ($booking->status === 'completed')
                            <span class="badge" style="background-color: #d1ecf1; color: #0c5460;">✓ Completed</span>
                        @else
                            <span class="badge badge-rented">✗ Cancelled</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
