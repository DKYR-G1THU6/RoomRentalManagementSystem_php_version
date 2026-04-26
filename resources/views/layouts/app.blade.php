<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Room Rental Management System')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('css')
</head>
<body class="app-page">
    <!-- Navigation Bar -->
    <div class="navbar">
        <a href="/" class="navbar-brand">Room Rental Management System</a>
        
        @auth
            <div class="navbar-center">
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ route('admin.rooms.index') }}" class="nav-link {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">Room Management</a>
                    <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">Order Management</a>
                    <a href="{{ route('admin.tenants') }}" class="nav-link {{ request()->routeIs('admin.tenants') ? 'active' : '' }}">Tenant Management</a>
                @else
                    <a href="{{ route('tenant.rooms') }}" class="nav-link {{ request()->routeIs('tenant.rooms', 'tenant.book-room', 'tenant.store-booking') ? 'active' : '' }}">View Rooms</a>
                    <a href="{{ route('tenant.bookings.my') }}" class="nav-link {{ request()->routeIs('tenant.bookings.*') ? 'active' : '' }}">My Orders</a>
                    <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">Profile</a>
                @endif
            </div>

            <div class="navbar-right">
                <div class="user-info">
                    <span class="user-name">{{ auth()->user()->name }}</span>
                    <span class="role-badge">
                        @if (auth()->user()->role === 'admin')
                            Administrator
                        @else
                            Tenant
                        @endif
                    </span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="rr-form-inline">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        @endauth
    </div>

    <!-- Main Content -->
    <div class="container">
        @if ($message = session('success'))
            <div class="alert alert-success">
                {{ $message }}
            </div>
        @endif

        @if ($message = session('error'))
            <div class="alert alert-error">
                {{ $message }}
            </div>
        @endif
        
        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Please correct the following errors：</strong>
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 Room Rental Management System | All Rights Reserved</p>
    </footer>

    @yield('js')
</body>
</html>
