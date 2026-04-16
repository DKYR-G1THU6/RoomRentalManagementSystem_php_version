@extends('layouts.app')

@section('title', '房间管理 - 房间租赁管理系统')

@section('content')
    <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <a href="{{ route('admin.dashboard') }}" style="color: #3498db; text-decoration: none;">← 返回仪表板</a>
        </div>
    </div>
    
    <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
        <h2 style="font-size: 24px; color: #2c3e50; margin: 0;">房间管理</h2>
        <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">➕ 添加新房间</a>
    </div>
    
    @if ($rooms->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>房间号</th>
                    <th>类型</th>
                    <th>价格 (¥)</th>
                    <th>状态</th>
                    <th>描述</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rooms as $room)
                    <tr>
                        <td><strong>#{{ $room->room_number }}</strong></td>
                        <td>{{ $room->type }}</td>
                        <td><strong>¥{{ number_format($room->price, 2) }}</strong></td>
                        <td>
                            @if ($room->status === 'available')
                                <span class="badge badge-available">✓ 可用</span>
                            @elseif ($room->status === 'rented')
                                <span class="badge badge-rented">✗ 已租赁</span>
                            @else
                                <span class="badge badge-maintenance">⚙ 维护中</span>
                            @endif
                        </td>
                        <td>{{ Str::limit($room->description, 30, '...') }}</td>
                        <td>
                            <a href="{{ route('admin.rooms.show', $room->id) }}" class="btn btn-primary" style="padding: 6px 10px; font-size: 12px;">查看</a>
                            <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-warning" style="padding: 6px 10px; font-size: 12px;">编辑</a>
                            <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('确定要删除这个房间吗?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 6px 10px; font-size: 12px;">删除</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="info-box" style="text-align: center; padding: 60px 30px;">
            <p style="font-size: 16px; color: #7f8c8d; margin-bottom: 20px;">暂无房间数据</p>
            <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">➕ 添加第一个房间</a>
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
        
        table .btn {
            margin: 0;
            padding: 6px 10px;
            font-size: 12px;
        }
    </style>
@endsection
