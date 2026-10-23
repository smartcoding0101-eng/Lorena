<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'preferences',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'preferences' => 'array',
            'is_admin' => 'boolean',
        ];
    }

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(AlbumPhoto::class);
    }

    public function gardenPosts(): HasMany
    {
        return $this->hasMany(GardenPost::class);
    }

    public function gardenProfile(): HasOne
    {
        return $this->hasOne(GardenProfile::class);
    }

    public function gardenMedia(): HasMany
    {
        return $this->hasMany(GardenMedia::class, 'user_id');
    }

    public function timeCapsules(): HasMany
    {
        return $this->hasMany(TimeCapsule::class);
    }
}
