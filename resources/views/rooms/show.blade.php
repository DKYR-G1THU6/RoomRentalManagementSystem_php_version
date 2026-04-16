@extends('layouts.app')

@section('title', '房间详情 - ' . $room->room_number)

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.rooms.index') }}" style="color: #3498db; text-decoration: none;">← 返回列表</a>
    </div>
    
    <h2 style="font-size: 24px; color: #2c3e50; margin-bottom: 20px;">房间详情</h2>
    
    <div class="info-box">
        <div class="info-row">
            <div class="info-label">房间号</div>
            <div class="info-value"><strong>#{{ $room->room_number }}</strong></div>
        </div>
        
        <div class="info-row">
            <div class="info-label">房间类型</div>
            <div class="info-value">{{ $room->type }}</div>
        </div>
        
        <div class="info-row">
            <div class="info-label">价格</div>
            <div class="info-value"><strong>¥{{ number_format($room->price, 2) }}</strong> / 晚</div>
        </div>
        
        <div class="info-row">
            <div class="info-label">状态</div>
            <div class="info-value">
                @if ($room->status === 'available')
                    <span class="badge badge-available">✓ 可用</span>
                @elseif ($room->status === 'rented')
                    <span class="badge badge-rented">✗ 已租赁</span>
                @else
                    <span class="badge badge-maintenance">⚙ 维护中</span>
                @endif
            </div>
        </div>
        
        <div class="info-row">
            <div class="info-label">描述</div>
            <div class="info-value">
                @if ($room->description)
                    {{ $room->description }}
                @else
                    <em style="color: #bdc3c7;">暂无描述</em>
                @endif
            </div>
        </div>
        
        <div class="info-row">
            <div class="info-label">创建时间</div>
            <div class="info-value">{{ $room->created_at->format('Y年m月d日 H:i') }}</div>
        </div>
        
        <div class="info-row">
            <div class="info-label">最后修改</div>
            <div class="info-value">{{ $room->updated_at->format('Y年m月d日 H:i') }}</div>
        </div>
    </div>
    
    <div class="actions">
        <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-warning">✏️ 编辑房间</a>
        
        <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('确定要删除这个房间吗?');">🗑️ 删除房间</button>
        </form>
        
        <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">← 返回列表</a>
    </div>
@endsection

@section('css')
    <style>
        .actions form {
            display: inline;
            padding: 0;
            box-shadow: none;
            background: transparent;
            margin: 0;
        }
    </style>
@endsection
