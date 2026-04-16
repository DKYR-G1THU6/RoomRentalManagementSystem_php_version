@extends('layouts.app')

@section('title', '编辑房间 - ' . $room->room_number)

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.rooms.index') }}" style="color: #3498db; text-decoration: none;">← 返回列表</a>
    </div>
    
    <h2 style="font-size: 24px; color: #2c3e50; margin-bottom: 30px;">编辑房间信息</h2>
    
    <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="room_number">房间号 <span style="color: #e74c3c;">*</span></label>
            <input 
                type="text" 
                id="room_number" 
                name="room_number" 
                value="{{ old('room_number', $room->room_number) }}"
                required
            >
            @error('room_number')
                <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="type">房间类型 <span style="color: #e74c3c;">*</span></label>
            <select id="type" name="type" required>
                <option value="">-- 请选择房间类型 --</option>
                <option value="单人房" {{ old('type', $room->type) === '单人房' ? 'selected' : '' }}>单人房</option>
                <option value="双人房" {{ old('type', $room->type) === '双人房' ? 'selected' : '' }}>双人房</option>
                <option value="三人房" {{ old('type', $room->type) === '三人房' ? 'selected' : '' }}>三人房</option>
                <option value="四人房" {{ old('type', $room->type) === '四人房' ? 'selected' : '' }}>四人房</option>
                <option value="五人房" {{ old('type', $room->type) === '五人房' ? 'selected' : '' }}>五人房</option>
                <option value="独立套房" {{ old('type', $room->type) === '独立套房' ? 'selected' : '' }}>独立套房</option>
            </select>
            @error('type')
                <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="price">价格 (¥) <span style="color: #e74c3c;">*</span></label>
            <input 
                type="number" 
                id="price" 
                name="price" 
                value="{{ old('price', $room->price) }}"
                step="0.01"
                min="0"
                required
            >
            @error('price')
                <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="status">状态 <span style="color: #e74c3c;">*</span></label>
            <select id="status" name="status" required>
                <option value="available" {{ old('status', $room->status) === 'available' ? 'selected' : '' }}>✓ 可用</option>
                <option value="rented" {{ old('status', $room->status) === 'rented' ? 'selected' : '' }}>✗ 已租赁</option>
                <option value="maintenance" {{ old('status', $room->status) === 'maintenance' ? 'selected' : '' }}>⚙ 维护中</option>
            </select>
            @error('status')
                <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="description">描述</label>
            <textarea 
                id="description" 
                name="description" 
                placeholder="输入房间的详细描述信息 (可选)"
            >{{ old('description', $room->description) }}</textarea>
            @error('description')
                <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 15px; font-weight: 600;">💾 保存修改</button>
            <a href="{{ route('admin.rooms.show', $room->id) }}" class="btn btn-secondary" style="padding: 12px 30px; font-size: 15px; font-weight: 600; text-decoration: none;">❌ 取消</a>
        </div>
    </form>
@endsection
