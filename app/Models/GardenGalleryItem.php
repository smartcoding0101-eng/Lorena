<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class GardenGalleryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'category',
        'pill',
        'tag_label',
        'quote',
        'image_path',
        'video_url',
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

    /**
     * Get the full URL for the image (supports local disk or absolute/external URL).
     */
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

