<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeasonAudio extends Model
{
    protected $table = 'season_audio';

    protected $fillable = [
        'season',
        'title',
        'file_path',
        'original_name',
        'mime_type',
        'file_size',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'file_size' => 'integer',
    ];

    protected $appends = ['url'];

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->file_path);
    }
}
