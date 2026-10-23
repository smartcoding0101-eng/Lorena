<?php

namespace App\Policies;

use App\Models\GardenPost;
use App\Models\User;

class GardenPostPolicy
{
    public function update(User $user, GardenPost $post): bool
    {
        return $user->id === $post->user_id;
    }

    public function delete(User $user, GardenPost $post): bool
    {
        return $user->id === $post->user_id;
    }

    public function publish(User $user, GardenPost $post): bool
    {
        return $user->id === $post->user_id && $post->kind === 'blog';
    }
}
