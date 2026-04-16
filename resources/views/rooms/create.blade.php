@extends('layouts.app')

@section('title', '添加新房间 - 房间租赁管理系统')

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.rooms.index') }}" style="color: #3498db; text-decoration: none;">← 返回列表</a>
    </div>
    
    <h2 style="font-size: 24px; color: #2c3e50; margin-bottom: 30px;">添加新房间</h2>
    
    <form action="{{ route('admin.rooms.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="room_number">房间号 <span style="color: #e74c3c;">*</span></label>
            <input 
                type="text" 
                id="room_number" 
                name="room_number" 
                value="{{ old('room_number') }}"
                placeholder="例如: 101, 102, 201"
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
                <option value="单人房" {{ old('type') === '单人房' ? 'selected' : '' }}>单人房</option>
                <option value="双人房" {{ old('type') === '双人房' ? 'selected' : '' }}>双人房</option>
                <option value="三人房" {{ old('type') === '三人房' ? 'selected' : '' }}>三人房</option>
                <option value="四人房" {{ old('type') === '四人房' ? 'selected' : '' }}>四人房</option>
                <option value="五人房" {{ old('type') === '五人房' ? 'selected' : '' }}>五人房</option>
                <option value="独立套房" {{ old('type') === '独立套房' ? 'selected' : '' }}>独立套房</option>
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
                value="{{ old('price') }}"
                step="0.01"
                min="0"
                placeholder="例如: 288.00"
                required
            >
            @error('price')
                <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="status">状态 <span style="color: #e74c3c;">*</span></label>
            <select id="status" name="status_display" disabled style="background-color: #ecf0f1; cursor: not-allowed;">
                <option value="available">✓ 可用</option>
            </select>
            <input type="hidden" name="status" value="available">
            <p style="font-size: 12px; color: #7f8c8d; margin-top: 5px;">新房间默认为可用状态，创建后可在编辑页面修改状态</p>
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
            >{{ old('description') }}</textarea>
            @error('description')
                <span style="color: #e74c3c; font-size: 13px;">{{ $message }}</span>
            @enderror
        </div>
        
        <div style="margin-top: 30px; display: flex; gap: 10px;">
            <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 15px; font-weight: 600;">➕ 添加房间</button>
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary" style="padding: 12px 30px; font-size: 15px; font-weight: 600; text-decoration: none;">❌ 取消</a>
        </div>
    </form>
@endsection