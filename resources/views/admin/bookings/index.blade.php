@extends('layouts.app')

@section('title', '订单管理')

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.dashboard') }}" style="color: #3498db; text-decoration: none;">← 返回仪表板</a>
    </div>
    
    <h2 style="font-size: 24px; color: #2c3e50; margin-bottom: 30px;">📋 订单管理</h2>
    
    @php
        $pendingBookings = $bookings->where('status', 'pending');
        $activeBookings = $bookings->where('status', 'active');
        $completedBookings = $bookings->where('status', 'completed');
        $cancelledBookings = $bookings->where('status', 'cancelled');
    @endphp
    
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 30px;">
        <div style="background: #fff3cd; padding: 15px; border-radius: 8px; border-left: 4px solid #f39c12;">
            <div style="font-size: 24px; font-weight: bold; color: #f39c12;">{{ $pendingBookings->count() }}</div>
            <div style="color: #7f8c8d; margin-top: 5px; font-size: 12px;">⏳ 待审批</div>
        </div>
        
        <div style="background: #d4edda; padding: 15px; border-radius: 8px; border-left: 4px solid #28a745;">
            <div style="font-size: 24px; font-weight: bold; color: #28a745;">{{ $activeBookings->count() }}</div>
            <div style="color: #7f8c8d; margin-top: 5px; font-size: 12px;">🏨 进行中</div>
        </div>
        
        <div style="background: #d1ecf1; padding: 15px; border-radius: 8px; border-left: 4px solid #017a8c;">
            <div style="font-size: 24px; font-weight: bold; color: #017a8c;">{{ $completedBookings->count() }}</div>
            <div style="color: #7f8c8d; margin-top: 5px; font-size: 12px;">✓ 已完成</div>
        </div>
        
        <div style="background: #f8d7da; padding: 15px; border-radius: 8px; border-left: 4px solid #e74c3c;">
            <div style="font-size: 24px; font-weight: bold; color: #e74c3c;">{{ $cancelledBookings->count() }}</div>
            <div style="color: #7f8c8d; margin-top: 5px; font-size: 12px;">✗ 已取消</div>
        </div>
    </div>
    
    @if ($pendingBookings->count() > 0)
        <h3 style="color: #2c3e50; margin-bottom: 20px; margin-top: 40px;">⏳ 待审批订单 ({{ $pendingBookings->count() }})</h3>
        <table style="margin-bottom: 40px;">
            <thead>
                <tr>
                    <th>租客</th>
                    <th>联系方式</th>
                    <th>房间</th>
                    <th>房间类型</th>
                    <th>入住日期</th>
                    <th>退住日期</th>
                    <th>总价</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendingBookings as $booking)
                    <tr>
                        <td>💼 <strong>{{ $booking->user->name }}</strong></td>
                        <td>{{ $booking->user->email }}</td>
                        <td><strong>#{{ $booking->room->room_number }}</strong></td>
                        <td>{{ $booking->room->type }}</td>
                        <td>{{ $booking->start_date->format('Y-m-d') }}</td>
                        <td>{{ $booking->end_date->format('Y-m-d') }}</td>
                        <td style="font-weight: bold; color: #27ae60;">¥{{ number_format($booking->total_price, 2) }}</td>
                        <td style="display: flex; gap: 8px;">
                            <form action="{{ route('admin.bookings.approve', $booking->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary" style="padding: 6px 12px; font-size: 12px; background-color: #27ae60; border: none; color: white; border-radius: 4px; cursor: pointer; font-weight: 600; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#229954';" onmouseout="this.style.backgroundColor='#27ae60';">✓ 批准</button>
                            </form>
                            <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 12px; background-color: #e74c3c; border: none; color: white; border-radius: 4px; cursor: pointer; font-weight: 600; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#c0392b';" onmouseout="this.style.backgroundColor='#e74c3c';">✗ 拒绝</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
    @if ($activeBookings->count() > 0)
        <h3 style="color: #2c3e50; margin-bottom: 20px;">🏨 进行中的订单 ({{ $activeBookings->count() }})</h3>
        <table style="margin-bottom: 40px;">
            <thead>
                <tr>
                    <th>租客</th>
                    <th>房间</th>
                    <th>类型</th>
                    <th>入住日期</th>
                    <th>退住日期</th>
                    <th>总价</th>
                    <th>操作</th>
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
                        <td>¥{{ number_format($booking->total_price, 2) }}</td>
                        <td>
                            <form action="{{ route('admin.bookings.complete', $booking->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary" style="padding: 6px 12px; font-size: 12px; background-color: #667eea; border: none; color: white; border-radius: 4px; cursor: pointer; font-weight: 600; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#5568d3';" onmouseout="this.style.backgroundColor='#667eea';">✓ 完成</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
    @if ($completedBookings->count() > 0)
        <h3 style="color: #2c3e50; margin-bottom: 20px;">✓ 已完成订单 ({{ $completedBookings->count() }})</h3>
        <table style="margin-bottom: 40px;">
            <thead>
                <tr>
                    <th>租客</th>
                    <th>房间</th>
                    <th>类型</th>
                    <th>入住日期</th>
                    <th>退住日期</th>
                    <th>总价</th>
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
                        <td>¥{{ number_format($booking->total_price, 2) }}</td>
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
