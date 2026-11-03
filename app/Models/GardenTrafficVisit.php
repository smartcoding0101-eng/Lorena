<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GardenTrafficVisit extends Model
{
    protected $table = 'garden_traffic_visits';

    protected $fillable = [
        'user_id',
        'visitor_uuid',
        'screen',
        'ip_address',
        'device',
        'browser',
        'os',
        'referer',
        'user_agent',
        'duration_seconds',
        'last_seen_at',
    ];

    protected $casts = [
        'last_seen_at' => 'datetime',
        'duration_seconds' => 'integer',
    ];

    protected $appends = [
        'user_display_name',
        'is_registered',
        'formatted_duration',
        'formatted_last_seen',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getIsRegisteredAttribute(): bool
    {
        return !is_null($this->user_id);
    }

    public function getUserDisplayNameAttribute(): string
    {
        if ($this->relationLoaded('user') && $this->user) {
            return $this->user->name . ' (' . $this->user->email . ')';
        }

        if ($this->user_id) {
            return 'Usuario #' . $this->user_id;
        }

        return 'Invitado ' . substr($this->visitor_uuid, 0, 8);
    }

    public function getFormattedDurationAttribute(): string
    {
        $sec = $this->duration_seconds ?? 0;
        if ($sec < 60) {
            return $sec . 's';
        }
        $min = floor($sec / 60);
        $remSec = $sec % 60;
        return $min . 'm ' . $remSec . 's';
    }

    public function getFormattedLastSeenAttribute(): string
    {
        if (!$this->last_seen_at) {
            return $this->created_at ? $this->created_at->diffForHumans() : 'Reciente';
        }
        return $this->last_seen_at->diffForHumans();
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', Carbon::today());
    }

    public function scopeOnlineNow(Builder $query, int $minutes = 5): Builder
    {
        return $query->where('last_seen_at', '>=', Carbon::now()->subMinutes($minutes));
    }

    public function scopeRegistered(Builder $query): Builder
    {
        return $query->whereNotNull('user_id');
    }

    public function scopeGuests(Builder $query): Builder
    {
        return $query->whereNull('user_id');
    }
}

