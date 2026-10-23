<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GardenQuizSession extends Model
{
    protected $primaryKey = 'token_hash';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'token_hash',
        'questions_snapshot',
        'current_index',
        'expires_at',
        'passed_at',
        'failed_at',
    ];

    protected $hidden = [
        'token_hash',
        'questions_snapshot',
    ];

    protected function casts(): array
    {
        return [
            'questions_snapshot' => 'array',
            'current_index' => 'integer',
            'expires_at' => 'datetime',
            'passed_at' => 'datetime',
            'failed_at' => 'datetime',
        ];
    }
}
