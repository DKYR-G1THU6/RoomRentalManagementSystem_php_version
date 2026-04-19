<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isTenant();
    }

    public function viewAdminList(User $user): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isTenant();
    }

    public function cancel(User $user, Booking $booking): bool
    {
        return $user->isTenant()
            && $booking->user_id === $user->id
            && $booking->status === 'pending';
    }

    public function approve(User $user, Booking $booking): bool
    {
        return $user->isAdmin() && $booking->status === 'pending';
    }

    public function reject(User $user, Booking $booking): bool
    {
        return $user->isAdmin() && $booking->status === 'pending';
    }

    public function complete(User $user, Booking $booking): bool
    {
        return $user->isAdmin() && $booking->status === 'active';
    }
}
