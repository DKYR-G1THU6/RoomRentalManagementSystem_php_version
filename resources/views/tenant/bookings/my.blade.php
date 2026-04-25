@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')
    <div style="margin-bottom: 40px;">
        <h2 style="font-size: 32px; color: #2c3e50; margin: 0;">My Bookings</h2>
    </div>
    
    @if ($bookings->count() > 0)
        @php
            $pendingBookings = $bookings->where('status', 'pending');
            $activeBookings = $bookings->where('status', 'active');
            $completedBookings = $bookings->where('status', 'completed');
            $cancelledBookings = $bookings->where('status', 'cancelled');
        @endphp
        
        @if ($pendingBookings->count() > 0)
            <div style="margin-bottom: 40px;">
                <div style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); padding: 20px 25px; border-radius: 8px; display: inline-block; margin-bottom: 20px; color: white;">
                    <h3 style="margin: 0; font-size: 18px; font-weight: 600;">Pending Bookings</h3>
                </div>
                <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f8f9fa; border-bottom: 2px solid #e0e0e0;">
                                <th style="padding: 15px 20px; text-align: left; color: #2c3e50; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Room No.</th>
                                <th style="padding: 15px 20px; text-align: left; color: #2c3e50; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Type</th>
                                <th style="padding: 15px 20px; text-align: left; color: #2c3e50; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Check-in</th>
                                <th style="padding: 15px 20px; text-align: left; color: #2c3e50; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Check-out</th>
                                <th style="padding: 15px 20px; text-align: right; color: #2c3e50; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Total Price</th>
                                <th style="padding: 15px 20px; text-align: center; color: #2c3e50; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendingBookings as $booking)
                                <tr style="border-bottom: 1px solid #ecf0f1; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#f8f9fa';" onmouseout="this.style.backgroundColor='white';">
                                    <td style="padding: 15px 20px; color: #2c3e50; font-weight: 600;">#{{ $booking->room->room_number }}</td>
                                    <td style="padding: 15px 20px; color: #555;">{{ $booking->room->type }}</td>
                                    <td style="padding: 15px 20px; color: #555;">{{ $booking->start_date->format('Y-m-d') }}</td>
                                    <td style="padding: 15px 20px; color: #555;">{{ $booking->end_date->format('Y-m-d') }}</td>
                                    <td style="padding: 15px 20px; text-align: right; color: #f39c12; font-weight: 600;">RM{{ number_format($booking->total_price, 2) }}</td>
                                    <td style="padding: 15px 20px; text-align: center;">
                                        <form action="{{ route('tenant.bookings.cancel', $booking->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="padding: 6px 12px; background-color: #e74c3c; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 600; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#c0392b';" onmouseout="this.style.backgroundColor='#e74c3c';">Cancel Booking</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        
        @if ($activeBookings->count() > 0)
            <div style="margin-bottom: 40px;">
                <div style="background: linear-gradient(135deg, #27ae60 0%, #229954 100%); padding: 20px 25px; border-radius: 8px; display: inline-block; margin-bottom: 20px; color: white;">
                    <h3 style="margin: 0; font-size: 18px; font-weight: 600;">Active Bookings</h3>
                </div>
                <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f8f9fa; border-bottom: 2px solid #e0e0e0;">
                                <th style="padding: 15px 20px; text-align: left; color: #2c3e50; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Room No.</th>
                                <th style="padding: 15px 20px; text-align: left; color: #2c3e50; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Type</th>
                                <th style="padding: 15px 20px; text-align: left; color: #2c3e50; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Check-in</th>
                                <th style="padding: 15px 20px; text-align: left; color: #2c3e50; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Check-out</th>
                                <th style="padding: 15px 20px; text-align: right; color: #2c3e50; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Total Price</th>
                                <th style="padding: 15px 20px; text-align: center; color: #2c3e50; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activeBookings as $booking)
                                <tr style="border-bottom: 1px solid #ecf0f1; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#f8f9fa';" onmouseout="this.style.backgroundColor='white';">
                                    <td style="padding: 15px 20px; color: #2c3e50; font-weight: 600;">#{{ $booking->room->room_number }}</td>
                                    <td style="padding: 15px 20px; color: #555;">{{ $booking->room->type }}</td>
                                    <td style="padding: 15px 20px; color: #555;">{{ $booking->start_date->format('Y-m-d') }}</td>
                                    <td style="padding: 15px 20px; color: #555;">{{ $booking->end_date->format('Y-m-d') }}</td>
                                    <td style="padding: 15px 20px; text-align: right; color: #27ae60; font-weight: 600;">RM{{ number_format($booking->total_price, 2) }}</td>
                                    <td style="padding: 15px 20px; text-align: center;">
                                        <span style="display: inline-block; background-color: #d5f4d5; color: #155724; padding: 6px 12px; border-radius: 4px; font-size: 12px; font-weight: 600;">Active</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        
        @if ($completedBookings->count() > 0)
            <div style="margin-bottom: 40px;">
                <div style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); padding: 20px 25px; border-radius: 8px; display: inline-block; margin-bottom: 20px; color: white;">
                    <h3 style="margin: 0; font-size: 18px; font-weight: 600;">Completed Bookings</h3>
                </div>
                <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f8f9fa; border-bottom: 2px solid #e0e0e0;">
                                <th style="padding: 15px 20px; text-align: left; color: #2c3e50; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Room No.</th>
                                <th style="padding: 15px 20px; text-align: left; color: #2c3e50; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Type</th>
                                <th style="padding: 15px 20px; text-align: left; color: #2c3e50; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Check-in</th>
                                <th style="padding: 15px 20px; text-align: left; color: #2c3e50; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Check-out</th>
                                <th style="padding: 15px 20px; text-align: right; color: #2c3e50; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Total Price</th>
                                <th style="padding: 15px 20px; text-align: center; color: #2c3e50; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($completedBookings as $booking)
                                <tr style="border-bottom: 1px solid #ecf0f1;" onmouseover="this.style.backgroundColor='#f8f9fa';" onmouseout="this.style.backgroundColor='white';">
                                    <td style="padding: 15px 20px; color: #2c3e50; font-weight: 600;">#{{ $booking->room->room_number }}</td>
                                    <td style="padding: 15px 20px; color: #555;">{{ $booking->room->type }}</td>
                                    <td style="padding: 15px 20px; color: #555;">{{ $booking->start_date->format('Y-m-d') }}</td>
                                    <td style="padding: 15px 20px; color: #555;">{{ $booking->end_date->format('Y-m-d') }}</td>
                                    <td style="padding: 15px 20px; text-align: right; color: #3498db; font-weight: 600;">RM{{ number_format($booking->total_price, 2) }}</td>
                                    <td style="padding: 15px 20px; text-align: center;">
                                        <span style="display: inline-block; background-color: #d1ecf1; color: #0c5460; padding: 6px 12px; border-radius: 4px; font-size: 12px; font-weight: 600;">Completed</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        
        @if ($cancelledBookings->count() > 0)
            <div style="margin-bottom: 40px;">
                <div style="background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%); padding: 20px 25px; border-radius: 8px; display: inline-block; margin-bottom: 20px; color: white;">
                    <h3 style="margin: 0; font-size: 18px; font-weight: 600;">Cancelled Bookings</h3>
                </div>
                <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background-color: #f8f9fa; border-bottom: 2px solid #e0e0e0;">
                                <th style="padding: 15px 20px; text-align: left; color: #2c3e50; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Room No.</th>
                                <th style="padding: 15px 20px; text-align: left; color: #2c3e50; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Type</th>
                                <th style="padding: 15px 20px; text-align: left; color: #2c3e50; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Check-in</th>
                                <th style="padding: 15px 20px; text-align: left; color: #2c3e50; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Check-out</th>
                                <th style="padding: 15px 20px; text-align: right; color: #2c3e50; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Total Price</th>
                                <th style="padding: 15px 20px; text-align: center; color: #2c3e50; font-weight: 600; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cancelledBookings as $booking)
                                <tr style="border-bottom: 1px solid #ecf0f1;" onmouseover="this.style.backgroundColor='#f8f9fa';" onmouseout="this.style.backgroundColor='white';">
                                    <td style="padding: 15px 20px; color: #2c3e50; font-weight: 600;">#{{ $booking->room->room_number }}</td>
                                    <td style="padding: 15px 20px; color: #555;">{{ $booking->room->type }}</td>
                                    <td style="padding: 15px 20px; color: #555;">{{ $booking->start_date->format('Y-m-d') }}</td>
                                    <td style="padding: 15px 20px; color: #555;">{{ $booking->end_date->format('Y-m-d') }}</td>
                                    <td style="padding: 15px 20px; text-align: right; color: #95a5a6; font-weight: 600;">RM{{ number_format($booking->total_price, 2) }}</td>
                                    <td style="padding: 15px 20px; text-align: center;">
                                        <span style="display: inline-block; background-color: #e2e3e5; color: #383d41; padding: 6px 12px; border-radius: 4px; font-size: 12px; font-weight: 600;">Cancelled</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    @else
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 80px 40px; text-align: center;">
            
            <p style="font-size: 18px; color: #2c3e50; font-weight: 600; margin-bottom: 10px;">No bookings yet</p>
            <p style="font-size: 14px; color: #7f8c8d; margin-bottom: 30px;">Start browsing available rooms and make a booking</p>
            <a href="{{ route('tenant.rooms') }}" style="display: inline-block; padding: 14px 30px; background-color: #667eea; color: white; border-radius: 4px; font-weight: 600; text-decoration: none; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#5568d3';" onmouseout="this.style.backgroundColor='#667eea';">Browse Available Rooms</a>
        </div>
    @endif
@endsection
