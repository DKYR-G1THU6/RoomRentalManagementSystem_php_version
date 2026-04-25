@extends('layouts.app')

@section('title', 'Browse Available Rooms')

@section('content')
    <div style="margin-bottom: 40px;">
        <h2 style="font-size: 32px; color: #2c3e50; margin: 0; margin-bottom: 10px;">Browse Available Rooms</h2>
        <p style="color: #7f8c8d; margin: 0;">Choose a room to make a booking</p>
    </div>
    
    @if ($rooms->count() > 0)
        <div class="room-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
            @foreach ($rooms as $room)
                <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden; transition: all 0.3s;" onmouseover="this.style.boxShadow='0 8px 20px rgba(0,0,0,0.12)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.08)'; this.style.transform='translateY(0)';">
                    <div style="background: #533ca5ff; padding: 20px; color: white;">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <div>
                                <h3 style="margin: 0; font-size: 22px;">Room #{{ $room->room_number }}</h3>
                                <p style="margin: 5px 0 0 0; opacity: 0.9; font-size: 14px;">{{ $room->type }}</p>
                            </div>
                            <div style="font-size: 28px;"></div>
                        </div>
                    </div>
                    
                    <div style="padding: 25px;">
                        <div style="margin-bottom: 20px;">
                            <p style="color: #7f8c8d; font-size: 13px; margin: 0 0 8px 0; text-transform: uppercase; letter-spacing: 0.5px;">Price Per Night</p>
                            <p style="color: #2c3e50; font-size: 28px; font-weight: bold; margin: 0;">RM{{ number_format($room->price, 2) }}</p>
                        </div>
                        
                        @if ($room->description)
                            <div style="margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #ecf0f1;">
                                <p style="color: #7f8c8d; font-size: 13px; margin: 0 0 8px 0; text-transform: uppercase; letter-spacing: 0.5px;">Room Description</p>
                                <p style="color: #555; font-size: 14px; margin: 0; line-height: 1.6;">{{ $room->description }}</p>
                            </div>
                        @endif
                        
                        <div style="display: flex; align-items: center; margin-bottom: 20px;">
                            <span style="display: inline-block; background-color: #d4edda; color: #155724; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">Available</span>
                        </div>
                        
                        <a href="{{ route('tenant.book-room', $room->id) }}" style="display: block; width: 100%; padding: 12px; text-align: center; text-decoration: none; background-color: #667eea; color: white; border-radius: 4px; font-weight: 600; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#5568d3';" onmouseout="this.style.backgroundColor='#667eea';">Book This Room</a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 80px 30px; text-align: center;">
            <p style="font-size: 18px; color: #7f8c8d; margin-bottom: 30px;">No available rooms at the moment</p>
            <p style="color: #7f8c8d; font-size: 14px; margin-bottom: 30px;">Please check back later</p>
        </div>
    @endif
@endsection

@section('css')
    <style>
        .tenant-room-layout {
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }

        .tenant-room-filters {
            width: 320px;
            position: sticky;
            top: 20px;
            align-self: flex-start;
        }

        .tenant-room-results {
            flex: 1;
            min-width: 0;
        }

        .tenant-room-scroll {
            max-height: calc(100vh - 260px);
            overflow-y: auto;
            padding-right: 10px;
        }

        @media (max-width: 1400px) {
            .room-grid {
                grid-template-columns: repeat(3, 1fr) !important;
            }
        }
        
        @media (max-width: 1024px) {
            .tenant-room-layout {
                flex-direction: column;
            }

            .tenant-room-filters {
                width: 100%;
                position: static;
            }

            .tenant-room-scroll {
                max-height: none;
                overflow: visible;
                padding-right: 0;
            }

            .room-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }
        }
        
        @media (max-width: 768px) {
            .room-grid {
                grid-template-columns: repeat(1, 1fr) !important;
            }
        }
    </style>
@endsection
