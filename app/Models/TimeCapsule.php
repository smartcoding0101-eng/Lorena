<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimeCapsule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'author_name',
        'unlock_at',
        'image_path',
        'mood',
        'is_opened',
    ];

    protected $casts = [
        'unlock_at' => 'datetime',
        'is_opened' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isUnlocked(): bool
    {
        return now()->greaterThanOrEqualTo($this->unlock_at);
    }
}
