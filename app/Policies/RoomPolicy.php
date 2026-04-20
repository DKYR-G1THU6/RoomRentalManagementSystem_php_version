<?php

namespace App\Policies;

use App\Models\Room;
use App\Models\User;

class RoomPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Room $room): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Room $room): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Room $room): bool
    {
        return $user->isAdmin();
    }

    public function viewAvailable(User $user): bool
    {
        return $user->isTenant();
    }

    public function book(User $user, Room $room): bool
    {
        return $user->isTenant() && $room->status === 'available';
    }
}
