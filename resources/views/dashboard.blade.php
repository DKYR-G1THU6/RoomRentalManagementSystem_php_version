{{-- This view should never be directly rendered.
     The /dashboard route in web.php handles role-based redirects.
     If you somehow see this, it means the route redirect failed. --}}
@php
    if (auth()->check()) {
        $role = auth()->user()->role;
        if ($role === 'admin') {
            header('Location: ' . route('admin.dashboard'));
        } else {
            header('Location: ' . route('tenant.rooms'));
        }
        exit();
    } else {
        header('Location: ' . route('login'));
        exit();
    }
@endphp
