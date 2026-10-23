<?php

namespace App\Policies;

use App\Models\GardenMedia;
use App\Models\User;

class GardenMediaPolicy
{
    public function view(User $user, GardenMedia $media): bool
    {
        return $user->id === $media->user_id;
    }

    public function delete(User $user, GardenMedia $media): bool
    {
        return $this->view($user, $media);
    }
}
