@extends('layouts.app')

@section('title', '管理员仪表板')

@section('content')
    <h2 style="font-size: 28px; color: #2c3e50; margin-bottom: 30px;">👑 管理员仪表板</h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 40px;">
        <div style="background: #e3f2fd; padding: 20px; border-radius: 8px; border-left: 4px solid #2196f3;">
            <div style="font-size: 28px; font-weight: bold; color: #2196f3;">{{ $stats['total_rooms'] }}</div>
            <div style="color: #7f8c8d; margin-top: 5px;">🏨 总房间数</div>
        </div>
        
        <div style="background: #e8f5e9; padding: 20px; border-radius: 8px; border-left: 4px solid #4caf50;">
            <div style="font-size: 28px; font-weight: bold; color: #4caf50;">{{ $stats['available_rooms'] }}</div>
            <div style="color: #7f8c8d; margin-top: 5px;">✓ 可用房间</div>
        </div>
        
        <div style="background: #fff3e0; padding: 20px; border-radius: 8px; border-left: 4px solid #ff9800;">
            <div style="font-size: 28px; font-weight: bold; color: #ff9800;">{{ $stats['rented_rooms'] }}</div>
            <div style="color: #7f8c8d; margin-top: 5px;">🚪 已租赁房间</div>
        </div>
        
        <div style="background: #fce4ec; padding: 20px; border-radius: 8px; border-left: 4px solid #e91e63;">
            <div style="font-size: 28px; font-weight: bold; color: #e91e63;">{{ $stats['maintenance_rooms'] }}</div>
            <div style="color: #7f8c8d; margin-top: 5px;">⚙️ 维护中房间</div>
        </div>
        
        <div style="background: #f3e5f5; padding: 20px; border-radius: 8px; border-left: 4px solid #9c27b0;">
            <div style="font-size: 28px; font-weight: bold; color: #9c27b0;">{{ $stats['total_tenants'] }}</div>
            <div style="color: #7f8c8d; margin-top: 5px;">👥 租客用户</div>
        </div>
        
        <div style="background: #e0f2f1; padding: 20px; border-radius: 8px; border-left: 4px solid #009688;">
            <div style="font-size: 28px; font-weight: bold; color: #009688;">{{ $stats['pending_bookings'] }}</div>
            <div style="color: #7f8c8d; margin-top: 5px;">⏳ 待审批订单</div>
        </div>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 40px;">
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="color: #2c3e50; margin: 0;">🔧 快速操作</h3>
            </div>
            <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary" style="width: 100%; margin-bottom: 10px; display: block; text-align: center; text-decoration: none;">➕ 添加房间</a>
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-primary" style="width: 100%; margin-bottom: 10px; display: block; text-align: center; text-decoration: none;">🏨 管理房间</a>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-warning" style="width: 100%; margin-bottom: 10px; display: block; text-align: center; text-decoration: none;">📋 处理订单</a>
            <a href="{{ route('admin.tenants') }}" class="btn btn-primary" style="width: 100%; display: block; text-align: center; text-decoration: none;">👥 管理租客</a>
        </div>
        
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="color: #2c3e50; margin: 0;">📊 统计数据</h3>
            </div>
            <div style="margin-bottom: 15px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #7f8c8d;">总订单数</span>
                    <strong style="color: #2c3e50;">{{ $stats['total_bookings'] }}</strong>
                </div>
            </div>
            <div style="margin-bottom: 15px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #7f8c8d;">进行中订单</span>
                    <strong style="color: #27ae60;">{{ $stats['active_bookings'] }}</strong>
                </div>
            </div>
            <div style="margin-bottom: 15px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #7f8c8d;">房间入住率</span>
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
        <h3 style="color: #2c3e50; margin-bottom: 20px;">⏳ 待审批订单 ({{ $pendingBookings->count() }})</h3>
        <table style="margin-bottom: 40px;">
            <thead>
                <tr>
                    <th>租客</th>
                    <th>房间</th>
                    <th>入住日期</th>
                    <th>退住日期</th>
                    <th>总价</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendingBookings as $booking)
                    <tr>
                        <td>💼 {{ $booking->user->name }}</td>
                        <td>#{{ $booking->room->room_number }}</td>
                        <td>{{ $booking->start_date->format('Y-m-d') }}</td>
                        <td>{{ $booking->end_date->format('Y-m-d') }}</td>
                        <td>¥{{ number_format($booking->total_price, 2) }}</td>
                        <td>
                            <form action="{{ route('admin.bookings.approve', $booking->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-primary" style="padding: 6px 10px; font-size: 12px; margin-right: 5px;">✓ 批准</button>
                            </form>
                            <form action="{{ route('admin.bookings.reject', $booking->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger" style="padding: 6px 10px; font-size: 12px;">✗ 拒绝</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
    <h3 style="color: #2c3e50; margin-bottom: 20px;">📅 最近的订单</h3>
    <table>
        <thead>
            <tr>
                <th>租客</th>
                <th>房间</th>
                <th>入住日期</th>
                <th>退住日期</th>
                <th>总价</th>
                <th>状态</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($recentBookings as $booking)
                <tr>
                    <td>{{ $booking->user->name }}</td>
                    <td>#{{ $booking->room->room_number }}</td>
                    <td>{{ $booking->start_date->format('Y-m-d') }}</td>
                    <td>{{ $booking->end_date->format('Y-m-d') }}</td>
                    <td>¥{{ number_format($booking->total_price, 2) }}</td>
                    <td>
                        @if ($booking->status === 'pending')
                            <span class="badge" style="background-color: #fff3cd; color: #856404;">⏳ 待审批</span>
                        @elseif ($booking->status === 'active')
                            <span class="badge badge-available">🏨 进行中</span>
                        @elseif ($booking->status === 'completed')
                            <span class="badge" style="background-color: #d1ecf1; color: #0c5460;">✓ 已完成</span>
                        @else
                            <span class="badge badge-rented">✗ 已取消</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
