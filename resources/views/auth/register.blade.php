<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Room Rental Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #d8d8d8;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

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
            color: #2e2d2dff;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
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
            font-weight: bold;
            transition: all 0.3s;
            display: inline-block;
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

        .nav-btn-primary {
            background-color: #002be9ff;
            color: white;
        }

        .nav-btn-primary:hover {
            background-color: #5568d3;
        }

        .container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 50px 40px;
            width: 100%;
            max-width: 500px;
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

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #bdc3c7;
            border-radius: 4px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .error {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 5px;
        }

        .btn {
            width: 100%;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background-color: #002fffff;
            color: white;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background-color: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .footer-actions {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ecf0f1;
        }

        .footer-actions a {
            font-size: 13px;
            color: #667eea;
            text-decoration: none;
        }

        .footer-actions a:hover {
            text-decoration: underline;
        }

        .info-text {
            font-size: 12px;
            color: #7f8c8d;
            margin-top: 10px;
            text-align: center;
        }

        .error-alert {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 12px 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <!-- 导航栏 -->
    <div class="navbar">
        <a href="{{ url('/') }}" class="navbar-brand">
            Room Rental Management System
        </a>
        <div class="navbar-actions">
            <a href="{{ url('/') }}" class="nav-btn nav-btn-secondary">Back to Home</a>
            <a href="{{ route('login') }}" class="nav-btn nav-btn-primary">Login</a>
        </div>
    </div>

    <!-- 注册容器 -->
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Register</h2>
                <p>Create your account</p>
            </div>

            @if ($errors->any())
                <div class="error-alert">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Username</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        required 
                        autofocus
                        placeholder="Enter your username"
                    >
                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required
                        placeholder="Enter your email address"
                    >
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        placeholder="Enter a secure password"
                    >
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        required
                        placeholder="Confirm your password"
                    >
                    @error('password_confirmation')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <p class="info-text">
                    After registration, you will become a tenant of the system. If you need administrator privileges, please contact the system administrator.
                </p>

                <button type="submit" class="btn btn-primary">Create Account</button>

                <div class="footer-actions">
                        Don't have an account? <a href="{{ route('login') }}">Register now</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
