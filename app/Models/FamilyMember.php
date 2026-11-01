<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FamilyMember extends Model
{
    protected $table = 'family_members';

    protected $fillable = [
        'slug',
        'name',
        'role_badge',
        'category',
        'avatar_icon',
        'bio',
        'special_date',
        'favorite_quote',
        'photo_path',
        'theme_color',
        'sort_order',
    ];

    protected $appends = [
        'photo_url',
    ];

    public function memories(): HasMany
    {
        return $this->hasMany(FamilyMemory::class, 'family_member_id');
    }

    public function getPhotoUrlAttribute(): ?string
    {
        if (!$this->photo_path) {
            return null;
        }

        $path = ltrim($this->photo_path, '/');
        if (str_starts_with($path, 'images/')) {
            return '/' . $path;
        }

        return '/storage/' . $path;
    }
}

