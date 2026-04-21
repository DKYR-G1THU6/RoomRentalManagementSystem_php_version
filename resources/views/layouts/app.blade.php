<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Room Rental Management System')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #f0f3f8 100%);
            color: #2c3e50;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar Styling */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            padding: 0 40px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .navbar-center {
            display: flex;
            gap: 30px;
            flex: 1;
            margin-left: 40px;
        }

        .nav-link {
            color: #2c3e50;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: color 0.3s;
            padding: 8px 0;
            border-bottom: 2px solid transparent;
        }

        .nav-link:hover {
            color: #667eea;
        }

        .nav-link.active {
            color: #667eea;
            border-bottom-color: #667eea;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-name {
            font-size: 14px;
            font-weight: 500;
            color: #2c3e50;
        }

        .role-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .logout-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 8px 18px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: background-color 0.3s;
            outline: none;
            box-shadow: none;
            -webkit-box-shadow: none;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
            flex: 1;
        }

        /* Alerts */
        .alert {
            padding: 16px 20px;
            margin-bottom: 24px;
            border-radius: 8px;
            font-weight: 500;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background-color: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .btn-danger {
            background-color: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .btn-warning {
            background-color: #f39c12;
            color: white;
        }

        .btn-warning:hover {
            background-color: #d68910;
        }

        .btn-secondary {
            background-color: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #7f8c8d;
        }

        /* Forms */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 14px;
        }

        input, textarea, select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #bdc3c7;
            border-radius: 6px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.3s;
        }

        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        thead {
            background-color: #f8f9fa;
            border-bottom: 2px solid #e0e0e0;
        }

        th {
            padding: 16px 20px;
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 16px 20px;
            border-bottom: 1px solid #ecf0f1;
        }

        tbody tr {
            transition: background-color 0.3s;
        }

        tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Cards */
        .card {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 24px;
        }

        .info-box {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .info-row {
            display: grid;
            grid-template-columns: 200px 1fr;
            padding: 15px 0;
            border-bottom: 1px solid #ecf0f1;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #2c3e50;
        }

        .info-value {
            color: #7f8c8d;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-available {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-rented {
            background-color: #f8d7da;
            color: #721c24;
        }

        .badge-maintenance {
            background-color: #fff3cd;
            color: #856404;
        }

        /* Errors */
        .error-list {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 8px;
            padding-left: 20px;
            list-style: none;
        }

        .error-list li {
            margin-bottom: 4px;
        }

        .error-list li:before {
            content: "✗ ";
            margin-right: 8px;
        }

        /* Footer */
        footer {
            background: rgba(255, 255, 255, 0.95);
            color: #7f8c8d;
            text-align: center;
            padding: 30px 20px;
            margin-top: 60px;
            border-top: 1px solid #ecf0f1;
            font-size: 14px;
        }

        footer p {
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar {
                padding: 0 20px;
            }

            .navbar-center {
                display: none;
            }

            .navbar-brand {
                font-size: 20px;
            }

            .info-row {
                grid-template-columns: 1fr;
            }

            .container {
                margin: 20px auto;
            }
        }
    </style>
    @yield('css')
</head>
<body>
    <!-- Navigation Bar -->
    <div class="navbar">
        <a href="/" class="navbar-brand">🏨 Room Rental Management System</a>
        
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
                    <span class="user-name">👤 {{ auth()->user()->name }}</span>
                    <span class="role-badge">
                        @if (auth()->user()->role === 'admin')
                            👑 Administrator
                        @else
                            🏠 Tenant
                        @endif
                    </span>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">🚪 Logout</button>
                </form>
            </div>
        @endauth
    </div>

    <!-- Main Content -->
    <div class="container">
        @if ($message = session('success'))
            <div class="alert alert-success">
                ✓ {{ $message }}
            </div>
        @endif

        @if ($message = session('error'))
            <div class="alert alert-error">
                ✗ {{ $message }}
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
