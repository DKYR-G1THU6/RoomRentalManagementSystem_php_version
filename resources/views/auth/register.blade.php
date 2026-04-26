<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Room Rental Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth-register-page">
    <!-- Navigation Bar -->
    <div class="navbar">
        <a href="{{ url('/') }}" class="navbar-brand">
            Room Rental Management System
        </a>
        <div class="navbar-actions">
            <a href="{{ url('/') }}" class="nav-btn nav-btn-secondary">Back to Home</a>
            <a href="{{ route('login') }}" class="nav-btn nav-btn-primary">Login</a>
        </div>
    </div>

    <!-- Registration Container -->
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
                        Have an account? <a href="{{ route('login') }}">Login now</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
