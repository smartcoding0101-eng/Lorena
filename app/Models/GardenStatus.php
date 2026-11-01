<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class GardenStatus extends Model
{
    protected $table = 'garden_statuses';

    protected $fillable = [
        'user_id',
        'caption',
        'image_path',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    protected $appends = [
        'image_url',
        'time_ago',
        'remaining_label',
        'expires_at_iso',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('expires_at', '>', now());
    }

    public function getImageUrlAttribute(): string
    {
        $path = ltrim((string) $this->image_path, '/');
        if (str_starts_with($path, 'images/')) {
            return asset($path);
        }

        return asset('storage/' . $path);
    }

    public function getTimeAgoAttribute(): string
    {
        if (!$this->created_at) {
            return 'Justo ahora';
        }

        return $this->created_at->locale('es')->diffForHumans();
    }

    public function getRemainingLabelAttribute(): string
    {
        if (!$this->expires_at || $this->expires_at->isPast()) {
            return 'Expirado';
        }

        $minutes = (int) max(1, now()->diffInMinutes($this->expires_at, false));
        if ($minutes >= 60) {
            $hours = (int) ceil($minutes / 60);
            return $hours . 'h';
        }

        return $minutes . 'm';
    }

    public function getExpiresAtIsoAttribute(): string
    {
        return ($this->expires_at ?? now()->addHours(24))->toIso8601String();
    }
}

