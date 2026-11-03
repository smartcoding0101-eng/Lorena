<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GardenProfile extends Model
{
    protected $fillable = [
        'user_id',
        'profession',
        'biography',
        'education',
        'experience',
        'achievements',
        'interests',
        'additional_info',
        'featured_photo_path',
        'status',
    ];

    protected $appends = [
        'featured_photo_url',
    ];

    public function getFeaturedPhotoUrlAttribute(): ?string
    {
        if (! $this->featured_photo_path || ! $this->id) {
            return null;
        }

        try {
            return route('profiles.featured-photo', $this);
        } catch (\Throwable) {
            return '/profiles/' . $this->id . '/featured-photo';
        }
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }
}
