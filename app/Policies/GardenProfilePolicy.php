<?php

namespace App\Policies;

use App\Models\GardenProfile;
use App\Models\User;

class GardenProfilePolicy
{
    public function view(?User $user, GardenProfile $profile): bool
    {
        return $profile->isPublished() || $user?->id === $profile->user_id;
    }

    public function update(User $user, GardenProfile $profile): bool
    {
        return $user->id === $profile->user_id;
    }
}
