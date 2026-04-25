@extends('layouts.app')

@section('title', 'Tenant Management')

@section('content')
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.dashboard') }}" style="color: #3498db; text-decoration: none;">← Back to Dashboard</a>
    </div>
    
    <h2 style="font-size: 24px; color: #2c3e50; margin-bottom: 30px;">Tenant Management</h2>

    <form method="GET" action="{{ route('admin.tenants') }}" style="margin-bottom: 20px;">
        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 10px; align-items: end;">
            <div>
                <label for="q" style="display:block; font-size: 12px; color: #7f8c8d; margin-bottom: 6px;">Search</label>
                <input id="q" name="q" type="text" value="{{ request('q') }}" placeholder="Username / email" style="width: 100%; padding: 10px; border: 1px solid #dfe6e9; border-radius: 6px;">
            </div>

            <div>
                <label for="active_booking" style="display:block; font-size: 12px; color: #7f8c8d; margin-bottom: 6px;">Active Booking</label>
                <select id="active_booking" name="active_booking" style="width: 100%; padding: 10px; border: 1px solid #dfe6e9; border-radius: 6px;">
                    <option value="">All</option>
                    <option value="1" @selected(request('active_booking') === '1')>Has Active</option>
                    <option value="0" @selected(request('active_booking') === '0')>No Active</option>
                </select>
            </div>

            <div>
                <label for="min_bookings" style="display:block; font-size: 12px; color: #7f8c8d; margin-bottom: 6px;">Min Total Bookings</label>
                <input id="min_bookings" name="min_bookings" type="number" min="0" value="{{ request('min_bookings') }}" style="width: 100%; padding: 10px; border: 1px solid #dfe6e9; border-radius: 6px;">
            </div>

            <div>
                <button type="submit" class="btn btn-primary" style="padding: 10px 14px;">Filter</button>
            </div>
        </div>
    </form>
    
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
                        <td><strong>{{ $tenant->name }}</strong></td>
                        <td>{{ $tenant->email }}</td>
                        <td>{{ $tenant->created_at->format('Y-m-d') }}</td>
                        <td>{{ $tenant->bookings_count ?? 0 }}</td>
                        <td>
                            @if (($tenant->active_bookings_count ?? 0) > 0)
                                <span class="badge badge-available">{{ $tenant->active_bookings_count }}</span>
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
                                <button type="submit" class="btn btn-danger" style="padding: 6px 10px; font-size: 12px;">Delete</button>
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
