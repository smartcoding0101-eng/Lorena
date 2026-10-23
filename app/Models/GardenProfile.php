<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GardenProfile extends Model
{
    protected $fillable = [
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }
}
