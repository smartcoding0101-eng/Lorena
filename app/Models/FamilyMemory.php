<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyMemory extends Model
{
    protected $table = 'family_memories';

    protected $fillable = [
        'family_member_id',
        'category',
        'title',
        'story',
        'memory_date',
        'emotion_tag',
        'image_path',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    protected $appends = [
        'image_url',
        'member_name',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(FamilyMember::class, 'family_member_id');
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image_path) {
            return '/images/carla-hero.jpg';
        }

        $path = ltrim($this->image_path, '/');
        if (str_starts_with($path, 'images/')) {
            return '/' . $path;
        }

        return '/storage/' . $path;
    }

    public function getMemberNameAttribute(): string
    {
        if ($this->relationLoaded('member') && $this->member) {
            return $this->member->name;
        }

        return match ($this->category) {
            'carla' => 'Carla Lorena',
            'adrian' => 'Adrián',
            'ody' => 'Mascota Ody',
            'children' => 'Nuestros Hijos',
            default => 'Toda la Familia',
        };
    }
}

