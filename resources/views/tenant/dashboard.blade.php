@extends('layouts.app')

@section('title', '租客仪表板')

@section('content')
    <div style="margin-bottom: 40px;">
        <h2 style="font-size: 32px; color: #2c3e50; margin-bottom: 5px;">👤 欢迎回来，{{ auth()->user()->name }}</h2>
        <p style="color: #7f8c8d; font-size: 14px;">这是您的个人租赁管理中心</p>
    </div>
    
    <!-- 统计卡片 -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 50px;">
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 25px; border-left: 5px solid #667eea;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <p style="color: #7f8c8d; font-size: 14px; margin: 0;">进行中的订单</p>
                    <p style="font-size: 36px; font-weight: bold; color: #667eea; margin: 10px 0 0 0;">{{ $stats['active_bookings'] }}</p>
                </div>
                <div style="font-size: 32px;">🏨</div>
            </div>
        </div>
        
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 25px; border-left: 5px solid #f39c12;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <p style="color: #7f8c8d; font-size: 14px; margin: 0;">待审批订单</p>
                    <p style="font-size: 36px; font-weight: bold; color: #f39c12; margin: 10px 0 0 0;">{{ $stats['pending_bookings'] }}</p>
                </div>
                <div style="font-size: 32px;">⏳</div>
            </div>
        </div>
        
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 25px; border-left: 5px solid #27ae60;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <p style="color: #7f8c8d; font-size: 14px; margin: 0;">已完成订单</p>
                    <p style="font-size: 36px; font-weight: bold; color: #27ae60; margin: 10px 0 0 0;">{{ $stats['completed_bookings'] }}</p>
                </div>
                <div style="font-size: 32px;">✓</div>
            </div>
        </div>
    </div>
    
    <!-- 快速操作 -->
    <h3 style="color: #2c3e50; font-size: 20px; margin-bottom: 20px;">快速操作</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 50px;">
        <a href="{{ route('tenant.rooms') }}" style="text-decoration: none; color: inherit;">
            <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 30px; text-align: center; transition: all 0.3s; cursor: pointer;" onmouseover="this.style.boxShadow='0 8px 16px rgba(0,0,0,0.15)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.08)'; this.style.transform='translateY(0)';">
                <div style="font-size: 40px; margin-bottom: 15px;">🔍</div>
                <h4 style="color: #2c3e50; margin: 0 0 10px 0;">浏览房间</h4>
                <p style="color: #7f8c8d; font-size: 14px; margin: 0;">查看所有可用房间</p>
            </div>
        </a>
        
        <a href="{{ route('tenant.bookings.my') }}" style="text-decoration: none; color: inherit;">
            <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 30px; text-align: center; transition: all 0.3s; cursor: pointer;" onmouseover="this.style.boxShadow='0 8px 16px rgba(0,0,0,0.15)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.08)'; this.style.transform='translateY(0)';">
                <div style="font-size: 40px; margin-bottom: 15px;">📋</div>
                <h4 style="color: #2c3e50; margin: 0 0 10px 0;">我的订单</h4>
                <p style="color: #7f8c8d; font-size: 14px; margin: 0;">查看和管理预订</p>
            </div>
        </a>
        
        <a href="{{ route('profile.edit') }}" style="text-decoration: none; color: inherit;">
            <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 30px; text-align: center; transition: all 0.3s; cursor: pointer;" onmouseover="this.style.boxShadow='0 8px 16px rgba(0,0,0,0.15)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.08)'; this.style.transform='translateY(0)';">
                <div style="font-size: 40px; margin-bottom: 15px;">👤</div>
                <h4 style="color: #2c3e50; margin: 0 0 10px 0;">个人资料</h4>
                <p style="color: #7f8c8d; font-size: 14px; margin: 0;">修改账户信息</p>
            </div>
        </a>
    </div>
    
    <!-- 最近订单 -->
    @if ($bookings->count() > 0)
        <h3 style="color: #2c3e50; font-size: 20px; margin-bottom: 20px;">📊 最近的订单</h3>
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f8f9fa; border-bottom: 2px solid #e0e0e0;">
                        <th style="padding: 15px; text-align: left; color: #2c3e50; font-weight: 600;">房间号</th>
                        <th style="padding: 15px; text-align: left; color: #2c3e50; font-weight: 600;">房间类型</th>
                        <th style="padding: 15px; text-align: left; color: #2c3e50; font-weight: 600;">入住日期</th>
                        <th style="padding: 15px; text-align: left; color: #2c3e50; font-weight: 600;">退住日期</th>
                        <th style="padding: 15px; text-align: left; color: #2c3e50; font-weight: 600;">总价</th>
                        <th style="padding: 15px; text-align: left; color: #2c3e50; font-weight: 600;">状态</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings->take(5) as $booking)
                        <tr style="border-bottom: 1px solid #e0e0e0;">
                            <td style="padding: 15px;"><strong>#{{ $booking->room->room_number }}</strong></td>
                            <td style="padding: 15px;">{{ $booking->room->type }}</td>
                            <td style="padding: 15px;">{{ $booking->start_date->format('Y-m-d') }}</td>
                            <td style="padding: 15px;">{{ $booking->end_date->format('Y-m-d') }}</td>
                            <td style="padding: 15px;">¥{{ number_format($booking->total_price, 2) }}</td>
                            <td style="padding: 15px;">
                                @if ($booking->status === 'pending')
                                    <span style="background-color: #fff3cd; color: #856404; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">⏳ 待审批</span>
                                @elseif ($booking->status === 'active')
                                    <span style="background-color: #d4edda; color: #155724; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">🏨 进行中</span>
                                @elseif ($booking->status === 'completed')
                                    <span style="background-color: #d1ecf1; color: #0c5460; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">✓ 已完成</span>
                                @else
                                    <span style="background-color: #f8d7da; color: #721c24; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">✗ 已取消</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ route('tenant.bookings.my') }}" style="color: #667eea; text-decoration: none; font-weight: 600;">查看全部订单 →</a>
        </div>
    @else
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 60px 30px; text-align: center;">
            <p style="font-size: 16px; color: #7f8c8d; margin-bottom: 20px;">还没有任何订单</p>
            <a href="{{ route('tenant.rooms') }}" class="btn btn-primary">开始浏览房间</a>
        </div>
    @endif
@endsection
