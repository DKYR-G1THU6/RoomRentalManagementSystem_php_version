<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password - Room Rental Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth-forgot-page">
    <!-- navigation bar -->
    <div class="navbar">
        <a href="{{ url('/') }}" class="navbar-brand">
            Room Rental Management System
        </a>
        <div class="navbar-actions">
            <a href="{{ url('/') }}" class="nav-btn nav-btn-secondary">Back to Home</a>
            <a href="{{ route('login') }}" class="nav-btn nav-btn-primary">Login</a>
        </div>
    </div>

    <!-- forget password container -->
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2> Forget Password</h2>
                <p>No problem, tell us your email address, and we will send you a password reset link to set a new password.</p>
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
                    ✓ {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
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
                        placeholder="Enter your registered email address"
                    >
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Send Password Reset Link</button>

                <div class="footer-actions">
                    <a href="{{ route('login') }}">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
