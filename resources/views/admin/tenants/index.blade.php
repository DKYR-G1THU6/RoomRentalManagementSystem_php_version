@extends('layouts.app')

@section('title', '租客管理')

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.dashboard') }}" style="color: #3498db; text-decoration: none;">← 返回仪表板</a>
    </div>
    
    <h2 style="font-size: 24px; color: #2c3e50; margin-bottom: 30px;">👥 租客管理</h2>
    
    @if ($tenants->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>用户名</th>
                    <th>邮箱</th>
                    <th>注册日期</th>
                    <th>订单数</th>
                    <th>进行中的订单</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tenants as $tenant)
                    <tr>
                        <td><strong>👤 {{ $tenant->name }}</strong></td>
                        <td>{{ $tenant->email }}</td>
                        <td>{{ $tenant->created_at->format('Y-m-d') }}</td>
                        <td>{{ $tenant->bookings->count() }}</td>
                        <td>
                            @php
                                $activeCount = $tenant->bookings->where('status', 'active')->count();
                            @endphp
                            @if ($activeCount > 0)
                                <span class="badge badge-available">{{ $activeCount }}</span>
                            @else
                                <span style="color: #bdc3c7;">-</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.tenants.delete', $tenant->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('确定要删除这个租客账号吗? 同时会删除该用户的所有预订记录。');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 6px 10px; font-size: 12px;">🗑️ 删除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="info-box" style="text-align: center; padding: 60px 30px;">
            <p style="font-size: 16px; color: #7f8c8d; margin-bottom: 20px;">暂无租客账号</p>
        </div>
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
