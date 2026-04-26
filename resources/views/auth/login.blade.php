<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Room Rental Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth-page">
    <!-- Navigation Bar -->
    <div class="navbar">
        <a href="{{ url('/') }}" class="navbar-brand">
            Room Rental Management System
        </a>
        <div class="navbar-actions">
            <a href="{{ url('/') }}" class="nav-btn nav-btn-secondary">Back to Home</a>
            <a href="{{ route('register') }}" class="nav-btn nav-btn-primary">Register</a>
        </div>
    </div>

    <!-- Login Container -->
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2>Login</h2>
                <p>Enter your account</p>
            </div>

            @if ($errors->any())
                <div class="error-alert">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @if (session('status'))
                <div class="success-alert auth-success-alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required 
                        autofocus
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
                        placeholder="Enter your password"
                    >
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="remember" name="remember" value="on">
                    <label for="remember">Remember me</label>
                </div>

                <button type="submit" class="btn btn-primary">Login</button>

                <div class="footer-actions">
                    <a href="{{ route('password.request') }}">Forget Password?</a>
                    <div class="register-link">
                        Don't have an account？<a href="{{ route('register') }}">Register now</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
