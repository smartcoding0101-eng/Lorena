<?php

namespace App\Policies;

use App\Models\AlbumPhoto;
use App\Models\User;

class AlbumPhotoPolicy
{
    public function view(User $user, AlbumPhoto $photo): bool
    {
        return $user->id === $photo->user_id && $photo->user_id === $photo->album->user_id;
    }

    public function update(User $user, AlbumPhoto $photo): bool
    {
        return $this->view($user, $photo);
    }

    public function delete(User $user, AlbumPhoto $photo): bool
    {
        return $this->view($user, $photo);
    }
}
