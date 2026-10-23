<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GardenQuizQuestion extends Model
{
    protected $fillable = [
        'question',
        'answer_hashes',
        'is_active',
    ];

    protected $hidden = [
        'answer_hashes',
    ];

    protected function casts(): array
    {
        return [
            'answer_hashes' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public static function hashAnswer(string $answer): string
    {
        $normalized = self::normalizeAnswer($answer);

        return hash_hmac('sha256', $normalized, (string) config('app.key'));
    }

    public static function normalizeAnswer(string $answer): string
    {
        $ascii = mb_strtolower(Str::ascii(trim($answer)));
        $normalized = preg_replace('/[^a-z0-9]+/', ' ', $ascii);

        return trim($normalized ?? '');
    }

    public function acceptsAnswer(string $answer): bool
    {
        $candidate = self::hashAnswer($answer);

        foreach ($this->answer_hashes ?? [] as $knownAnswerHash) {
            if (is_string($knownAnswerHash) && hash_equals($knownAnswerHash, $candidate)) {
                return true;
            }
        }

        return false;
    }
}
