@extends('layouts.app')

@section('title', 'Tenant Management')

@section('content')
    <div class="tenant-management-top">
        <a href="{{ route('admin.dashboard') }}" class="rr-link-back">← Back to Dashboard</a>
    </div>
    
    <h2 class="tenant-management-title">Tenant Management</h2>

    <form method="GET" action="{{ route('admin.tenants') }}" class="rr-filter-grid rr-filter-grid-tenants">
            <div>
                <label for="q" class="rr-filter-label">Search</label>
                <input id="q" name="q" type="text" value="{{ request('q') }}" placeholder="Username / email" class="rr-filter-control">
            </div>

            <div>
                <label for="active_booking" class="rr-filter-label">Active Booking</label>
                <select id="active_booking" name="active_booking" class="rr-filter-control">
                    <option value="">All</option>
                    <option value="1" @selected(request('active_booking') === '1')>Has Active</option>
                    <option value="0" @selected(request('active_booking') === '0')>No Active</option>
                </select>
            </div>

            <div>
                <label for="min_bookings" class="rr-filter-label">Min Total Bookings</label>
                <input id="min_bookings" name="min_bookings" type="number" min="0" value="{{ request('min_bookings') }}" class="rr-filter-control">
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Filter</button>
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
                                <span class="rr-muted-dash">-</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.tenants.delete', $tenant->id) }}"
                             method="POST" class="rr-inline-form" 
                            onsubmit="return confirm('Are you sure you want to delete this tenant account? All their booking records will also be deleted.');"
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn rr-btn-xs btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="info-box rr-empty-state--center">
            <p class="rr-empty-state__text">No tenant accounts found</p>
        </div>
    @endif
@endsection
