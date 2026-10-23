<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GardenQuizSettings extends Model
{
    protected $fillable = [
        'id',
        'reward_image_path',
        'reward_authorized_at',
    ];

    protected function casts(): array
    {
        return [
            'reward_authorized_at' => 'datetime',
        ];
    }
}
