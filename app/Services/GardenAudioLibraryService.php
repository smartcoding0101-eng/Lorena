<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class GardenAudioLibraryService
{
    /**
     * Extensiones de audio compatibles con navegadores web modernos.
     */
    protected const ALLOWED_EXTENSIONS = ['mp3', 'm4a', 'wav', 'ogg', 'oga', 'aac', 'flac', 'webm'];

    /**
     * Escanea el directorio public/audio y retorna una colección con los metadatos de cada pista.
     *
     * @return Collection<int, array<string, mixed>>
     */
    public static function getPublicAudioTracks(): Collection
    {
        $audioDir = public_path('audio');

        if (! File::isDirectory($audioDir)) {
            File::makeDirectory($audioDir, 0755, true, true);
            return collect();
        }

        $files = File::files($audioDir);
        $tracks = collect();

        foreach ($files as $file) {
            $ext = strtolower($file->getExtension());
            if (! in_array($ext, self::ALLOWED_EXTENSIONS, true)) {
                continue;
            }

            $filename = $file->getFilename();
            $title = self::formatTitle($file->getFilenameWithoutExtension());
            $size = $file->getSize();
            $url = asset('audio/' . rawurlencode($filename));

            $tracks->push([
                'id' => 'pub_audio_' . substr(md5($filename), 0, 12),
                'title' => $title,
                'description' => 'Música del Jardín · ' . $filename,
                'artist' => 'El Jardín de Carla Lorena',
                'media_type' => 'audio',
                'source_type' => 'external_audio',
                'source_url' => $url,
                'stream_url' => $url,
                'url' => $url,
                'type' => 'audio',
                'is_public_library' => true,
                'file_name' => $filename,
                'file_size' => $size,
                'file_size_formatted' => self::formatBytes($size),
                'sourceBadge' => 'Música del Jardín',
                'youtube_embed_url' => null,
            ]);
        }

        return $tracks->sortBy('title', SORT_NATURAL | SORT_FLAG_CASE)->values();
    }

    /**
     * Limpia y embellece el nombre del archivo para mostrarlo como título elegante.
     */
    public static function formatTitle(string $raw): string
    {
        $decoded = rawurldecode($raw);

        // Remover prefijos numéricos típicos (ej: "01. ", "02 - ", "1_", "[01] ")
        $clean = preg_replace('/^(?:\[?\d{1,3}\]?[\s._\-–—]+)/u', '', $decoded);

        // Reemplazar guiones bajos y guiones por espacios
        $clean = preg_replace('/[_\-]+/u', ' ', $clean ?? $decoded);

        // Limpiar espacios múltiples
        $clean = trim(preg_replace('/\s+/u', ' ', $clean ?? '') ?? '');

        if ($clean === '') {
            $clean = $decoded;
        }

        return mb_convert_case($clean, MB_CASE_TITLE, 'UTF-8');
    }

    /**
     * Formatea bytes a tamaño legible para el usuario (ej: 4.2 MB).
     */
    public static function formatBytes(int $bytes, int $precision = 1): string
    {
        if ($bytes <= 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $power = (int) floor(log($bytes, 1024));
        $power = min($power, count($units) - 1);

        return round($bytes / pow(1024, $power), $precision) . ' ' . $units[$power];
    }
}
