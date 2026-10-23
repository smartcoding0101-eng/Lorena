<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GardenMedia extends Model
{
    protected $table = 'garden_media';

    protected $fillable = [
        'title',
        'description',
        'media_type',
        'source_type',
        'source_url',
        'path',
        'mime_type',
        'file_size',
    ];

    public static function youtubeVideoIdFromUrl(string $url): ?string
    {
        $parts = parse_url($url);
        if (! is_array($parts)
            || strtolower($parts['scheme'] ?? '') !== 'https'
            || isset($parts['user'])
            || isset($parts['pass'])
            || (isset($parts['port']) && $parts['port'] !== 443)) {
            return null;
        }

        $host = strtolower($parts['host'] ?? '');
        $path = trim($parts['path'] ?? '', '/');
        $videoId = null;

        if (in_array($host, ['youtu.be', 'www.youtu.be'], true)) {
            $videoId = $path;
        } elseif (in_array($host, ['youtube.com', 'www.youtube.com', 'm.youtube.com'], true)) {
            if ($path === 'watch') {
                parse_str($parts['query'] ?? '', $query);
                $videoId = $query['v'] ?? null;
            } elseif (preg_match('/\A(?:embed|shorts|live)\/([A-Za-z0-9_-]{11})\/?\z/', $path, $matches) === 1) {
                $videoId = $matches[1];
            }
        }

        return is_string($videoId) && preg_match('/\A[A-Za-z0-9_-]{11}\z/', $videoId) === 1
            ? $videoId
            : null;
    }

    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        if ($this->source_type !== 'youtube' || ! is_string($this->source_url)) {
            return null;
        }

        $videoId = self::youtubeVideoIdFromUrl($this->source_url);

        return $videoId === null ? null : 'https://www.youtube-nocookie.com/embed/'.$videoId;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
