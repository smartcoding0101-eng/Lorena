<?php

namespace App\Policies;

use App\Models\Album;
use App\Models\User;

class AlbumPolicy
{
    public function view(User $user, Album $album): bool
    {
        return $user->id === $album->user_id;
    }

    public function update(User $user, Album $album): bool
    {
        return $this->view($user, $album);
    }

    public function delete(User $user, Album $album): bool
    {
        return $this->view($user, $album);
    }
}
