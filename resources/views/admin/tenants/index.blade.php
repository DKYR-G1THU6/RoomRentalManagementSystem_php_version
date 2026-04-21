@extends('layouts.app')

@section('title', 'Tenant Management')

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.dashboard') }}" style="color: #3498db; text-decoration: none;">← Back to Dashboard</a>
    </div>
    
    <h2 style="font-size: 24px; color: #2c3e50; margin-bottom: 30px;">👥 Tenant Management</h2>
    
    @if ($tenants->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Registered Date</th>
                    <th>Total Bookings</th>
                    <th>Active Bookings</th>
                    <th>Action</th>
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
                            <form action="{{ route('admin.tenants.delete', $tenant->id) }}"
                             method="POST" style="display: inline;" 
                            onsubmit="return confirm('Are you sure you want to delete this tenant account? All their booking records will also be deleted.');"
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 6px 10px; font-size: 12px;">🗑️ Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="info-box" style="text-align: center; padding: 60px 30px;">
            <p style="font-size: 16px; color: #7f8c8d; margin-bottom: 20px;">No tenant accounts found</p>
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
