<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GardenPost extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'kind',
        'status',
        'category',
        'excerpt',
        'body',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePublishedBlog(Builder $query): Builder
    {
        return $query->where('kind', 'blog')->where('status', 'published');
    }

    public function isPrivateDiary(): bool
    {
        return $this->kind === 'diary';
    }
}
