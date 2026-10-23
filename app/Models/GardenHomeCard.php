<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class GardenHomeCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'emblem_icon',
        'description',
        'quote',
        'target_screen',
        'style_variant',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
