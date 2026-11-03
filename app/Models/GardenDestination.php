<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class GardenDestination extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'location_tag',
        'description',
        'image_path',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected $appends = [
        'image_url',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getImageUrlAttribute(): string
    {
        if (empty($this->image_path)) {
            return asset('images/mockups/propuesta_b_natural_light.png');
        }

        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            return $this->image_path;
        }

        if (str_starts_with($this->image_path, '/')) {
            return $this->image_path;
        }

        if (str_starts_with($this->image_path, 'storage/')) {
            return '/' . ltrim($this->image_path, '/');
        }

        if (Storage::disk('public')->exists($this->image_path) || file_exists(public_path('storage/' . ltrim($this->image_path, '/')))) {
            return '/storage/' . ltrim($this->image_path, '/');
        }

        if (file_exists(public_path(ltrim($this->image_path, '/')))) {
            return '/' . ltrim($this->image_path, '/');
        }

        return '/storage/' . ltrim($this->image_path, '/');
    }
}

