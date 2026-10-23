<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendDedication extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_name',
        'message',
        'flower_badge',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
