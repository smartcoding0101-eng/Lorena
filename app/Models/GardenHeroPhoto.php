<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GardenHeroPhoto extends Model
{
    protected $table = 'garden_hero_photos';

    protected $fillable = [
        'user_id',
        'photo_path',
        'caption',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected $appends = [
        'url',
    ];

    public function getUrlAttribute(): string
    {
        return route('hero-photos.show', $this);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

