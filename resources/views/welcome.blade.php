<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Rental Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
            min-height: 100vh;
            padding: 0;
        }

        /* 导航栏 */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            padding: 0 40px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-actions {
            display: flex;
            gap: 15px;
        }

        .nav-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
        }

        .nav-btn-primary {
            background-color: #667eea;
            color: white;
        }

        .nav-btn-primary:hover {
            background-color: #5568d3;
        }

        .nav-btn-secondary {
            border: 1px solid #667eea;
            color: #667eea;
            background-color: transparent;
        }

        .nav-btn-secondary:hover {
            background-color: #667eea;
            color: white;
        }

        /* 主容器 */
        .main-container {
            display: flex;
            height: calc(100vh - 70px);
        }

        /* 左侧 - 特性介绍 */
        .hero-section {
            flex: 1;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
        }

        .hero-section h1 {
            font-size: 42px;
            margin-bottom: 20px;
        }

        .hero-section > p {
            font-size: 18px;
            margin-bottom: 40px;
            opacity: 0.9;
        }

        .feature-list {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .feature-item {
            display: flex;
            gap: 15px;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            backdrop-filter: blur(10px);
        }

        .feature-item-icon {
            font-size: 28px;
            min-width: 30px;
        }

        .feature-item-text h4 {
            margin-bottom: 5px;
            font-size: 15px;
        }

        .feature-item-text p {
            font-size: 13px;
            opacity: 0.8;
        }

        
        .welcome-panel {
            flex: 1;
            background: white;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-shadow: -10px 0 40px rgba(0,0,0,0.1);
        }

        .card {
            width: 100%;
            max-width: 400px;
        }

        .card-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .card-header h2 {
            color: #2c3e50;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .card-header p {
            color: #7f8c8d;
            font-size: 14px;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .btn {
            padding: 15px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
            text-align: center;
            font-weight: 600;
        }

        .btn-primary {
            background-color: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background-color: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background-color: #ecf0f1;
            color: #2c3e50;
            border: 1px solid #bdc3c7;
        }

        .btn-secondary:hover {
            background-color: #bdc3c7;
            transform: translateY(-2px);
        }

        .divider {
            height: 1px;
            background: #ecf0f1;
            margin: 20px 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .divider:after {
            content: "or";
            background: white;
            padding: 0 10px;
            color: #7f8c8d;
            font-size: 14px;
        }

        /* 用户已登录的欢迎面板 */
        .welcome-card {
            background: white;
            border-radius: 8px;
            padding: 40px;
            text-align: center;
            max-width: 500px;
            width: 100%;
        }

        .welcome-card h2 {
            color: #2c3e50;
            font-size: 28px;
            margin-bottom: 15px;
        }

        .welcome-card .role-badge {
            display: inline-block;
            padding: 8px 16px;
            background: #e8f4f8;
            color: #667eea;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 30px;
        }

        .welcome-card .role-badge.admin {
            background: #fff3e0;
            color: #f39c12;
        }

        .welcome-actions {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 30px;
        }

        .info-section {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #ecf0f1;
            text-align: left;
        }

        .info-section h3 {
            color: #2c3e50;
            font-size: 16px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .info-list li {
            color: #555;
            font-size: 13px;
            padding: 8px 0;
            display: flex;
            align-items: center;
            gap: 8px;
            list-style: none;
        }

        .info-list li:before {
            content: "✓";
            color: #27ae60;
            font-weight: bold;
        }

        @media (max-width: 1024px) {
            .main-container {
                flex-direction: column;
                height: auto;
            }
            
            .hero-section {
                padding: 40px 30px;
                height: auto;
            }
            
            .welcome-panel {
                padding: 40px 30px;
                box-shadow: none;
                border-top: 1px solid #ecf0f1;
            }

            .feature-list {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- 导航栏 -->
    <div class="navbar">
        <div class="navbar-brand">
            Room Rental Management System
        </div>
        @auth
            <div class="navbar-actions">
                <span style="color: #2c3e50; font-weight: 600;">{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
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

                    <a href="{{ route('profile.edit') }}" style="color: #667eea; text-decoration: none; font-size: 14px;">Edit Profile</a>

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
