<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Rental Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="welcome-page">
    <!-- 导航栏 -->
    <div class="navbar">
        <div class="navbar-brand">
            Room Rental Management System
        </div>
        @auth
            <div class="navbar-actions">
                <span class="welcome-user-name">{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="welcome-logout-form">
                    @csrf
                    <button type="submit" class="nav-btn nav-btn-primary">Log Out</button>
                </form>
            </div>
        @else
            <div class="navbar-actions">
                <a href="{{ route('login') }}" class="nav-btn nav-btn-secondary">Login</a>
                <a href="{{ route('register') }}" class="nav-btn nav-btn-primary">Register</a>
            </div>
        @endauth
    </div>

    <!-- 主容器 -->
    <div class="main-container">
        <!-- 左侧 - 特性介绍（仅未登录用户） -->
        @guest
            <div class="hero-section">
                <h1>Easy to Manage Your Room Bookings</h1>
                <p>One-stop room rental solution</p>
                
                <div class="feature-list">
                    <div class="feature-item">
                        <div class="feature-item-icon"></div>
                        <div class="feature-item-text">
                            <h4>Browse Rooms</h4>
                            <p>Discover all available quality rooms</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-item-icon"></div>
                        <div class="feature-item-text">
                            <h4>Online Booking</h4>
                            <p>Select dates to book easily</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-item-icon"></div>
                        <div class="feature-item-text">
                            <h4>Secure Payment</h4>
                            <p>Reliable transaction system</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-item-icon"></div>
                        <div class="feature-item-text">
                            <h4>Complete Management</h4>
                            <p>Professional system management tools</p>
                        </div>
                    </div>
                </div>
            </div>
        @endguest

        
        <div class="welcome-panel">
            @auth
                
                <div class="welcome-card">
                    <h2>Welcome back, {{ auth()->user()->name }}!</h2>
                    <div class="role-badge @if (auth()->user()->role === 'admin') admin @endif">
                        @if (auth()->user()->role === 'admin')
                            Admin Account
                        @else
                            Tenant Account
                        @endif
                    </div>

                    <div class="welcome-actions">
                        @if (auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Admin Dashboard</a>
                            <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Room Management</a>
                        @else
                            <a href="{{ route('tenant.rooms') }}" class="btn btn-primary">Browse Rooms</a>
                            <a href="{{ route('tenant.bookings.my') }}" class="btn btn-secondary">My Bookings</a>
                        @endif
                    </div>

                    <a href="{{ route('profile.edit') }}" class="welcome-edit-link-inline">Edit Profile</a>

                    <div class="info-section">
                        <h3>
                            @if (auth()->user()->role === 'admin')
                                Admin Functions
                            @else
                                Tenant Functions
                            @endif
                        </h3>
                        <ul class="info-list">
                            @if (auth()->user()->role === 'admin')
                                <li>Add and edit rooms</li>
                                <li>Approve order applications</li>
                                <li>Manage tenant accounts</li>
                                <li>View system data</li>
                                <li>Manage room list</li>
                                <li>Track booking status</li>
                            @else
                                <li>Browse available rooms</li>
                                <li>Book rooms online</li>
                                <li>View order status</li>
                                <li>Cancel orders</li>
                                <li>Manage personal profile</li>
                                <li>Payment management</li>
                            @endif
                        </ul>
                    </div>
                </div>
            @else
                <!-- 未登录用户 -->
                <div class="card">
                    <div class="card-header">
                        <h2>Start Experience</h2>
                        <p>Login or register to start using the system</p>
                    </div>
                    
                    <div class="card-body">
                        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                        <div class="divider"></div>
                        <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                    </div>

                    <div class="info-section">
                        <h3>Tenant</h3>
                        <ul class="info-list">
                            <li>Browse all rooms</li>
                            <li>Online booking rooms</li>
                            <li>View order status</li>
                            <li>Manage personal profile</li>
                        </ul>
                    </div>

                    <div class="info-section">
                        <h3>Admin</h3>
                        <ul class="info-list">
                            <li>Room management</li>
                            <li>Order review and assignment</li>
                            <li>Tenant management</li>
                            <li>Data statistics</li>
                        </ul>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</body>
</html>
