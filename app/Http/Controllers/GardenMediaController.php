<?php

namespace App\Http\Controllers;

use App\Models\GardenMedia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File;
use RuntimeException;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GardenMediaController extends Controller
{
    private const VIDEO_MAX_KILOBYTES = 102400;

    private const AUDIO_MAX_KILOBYTES = 20480;

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'source_type' => ['required', 'in:upload,youtube,external_audio'],
            'title' => ['required', 'string', 'min:1', 'max:160'],
            'description' => ['nullable', 'string', 'max:4000'],
        ]);

        $sourceType = $validated['source_type'];
        if ($sourceType === 'upload') {
            $this->storeUpload($request, $validated);
        } else {
            $this->storeLink($request, $validated);
        }

        return redirect()->to(route('home').'#entretenimiento')
            ->with('status', match ($sourceType) {
                'youtube' => 'Enlace de YouTube agregado a tu espacio privado.',
                'external_audio' => 'Enlace de audio MP3 agregado a tu espacio privado.',
                default => 'Archivo agregado a tu espacio privado.',
            });
    }

    /**
     * @param  array{source_type: string, title: string, description?: string|null}  $validated
     */
    private function storeUpload(Request $request, array $validated): void
    {
        $uploadDetails = $request->validate([
            'media_type' => ['required', 'in:video,audio'],
        ]);
        $validated = [...$validated, ...$uploadDetails, ...$request->validate([
            'file' => [
                'required',
                File::types($uploadDetails['media_type'] === 'video'
                    ? ['mp4', 'webm', 'mov']
                    : ['mp3', 'm4a', 'aac', 'wav', 'ogg', 'oga', 'webm'])
                    ->max($uploadDetails['media_type'] === 'video' ? self::VIDEO_MAX_KILOBYTES : self::AUDIO_MAX_KILOBYTES),
            ],
        ])];
        $upload = $validated['file'];
        $extension = $upload->guessExtension();
        if (! is_string($extension) || $extension === '') {
            abort(422, 'No se pudo determinar el formato del archivo.');
        }

        $path = sprintf('entertainment/%d/%s.%s', $request->user()->id, Str::uuid(), $extension);
        $disk = Storage::disk('garden_private');
        $storedPath = $disk->putFileAs(dirname($path), $upload, basename($path));
        if (! is_string($storedPath)) {
            throw new RuntimeException('No se pudo guardar el archivo de entretenimiento.');
        }

        try {
            $request->user()->gardenMedia()->create([
                'title' => trim($validated['title']),
                'description' => isset($validated['description']) ? trim($validated['description']) : null,
                'media_type' => $validated['media_type'],
                'source_type' => 'upload',
                'source_url' => null,
                'path' => $storedPath,
                'mime_type' => $upload->getMimeType(),
                'file_size' => $upload->getSize(),
            ]);
        } catch (\Throwable $exception) {
            $disk->delete($storedPath);
            throw $exception;
        }
    }

    /**
     * @param  array{source_type: string, title: string, description?: string|null}  $validated
     */
    private function storeLink(Request $request, array $validated): void
    {
        $sourceType = $validated['source_type'];
        $urlValidator = function (string $attribute, mixed $value, \Closure $fail) use ($sourceType): void {
            if (! is_string($value) || strlen($value) > 2048 || ! $this->isHttpsExternalUrl($value)) {
                $fail('Introduce una URL HTTPS válida, sin usuario ni contraseña.');

                return;
            }

            if ($sourceType === 'youtube' && GardenMedia::youtubeVideoIdFromUrl($value) === null) {
                $fail('Introduce un enlace válido a un video de YouTube.');
            }

            if ($sourceType === 'external_audio') {
                $path = parse_url($value, PHP_URL_PATH);
                if (! is_string($path) || preg_match('/\.mp3\z/i', $path) !== 1) {
                    $fail('El enlace debe apuntar directamente a un archivo MP3.');
                }
            }
        };

        $validated = [...$validated, ...$request->validate([
            'source_url' => ['required', 'string', 'url:https', $urlValidator],
        ])];
        $isYoutube = $sourceType === 'youtube';
        $request->user()->gardenMedia()->create([
            'title' => trim($validated['title']),
            'description' => isset($validated['description']) ? trim($validated['description']) : null,
            'media_type' => $isYoutube ? 'video' : 'audio',
            'source_type' => $sourceType,
            'source_url' => $validated['source_url'],
            'path' => null,
            'mime_type' => null,
            'file_size' => null,
        ]);
    }

    private function isHttpsExternalUrl(string $url): bool
    {
        $parts = parse_url($url);

        return is_array($parts)
            && strtolower($parts['scheme'] ?? '') === 'https'
            && isset($parts['host'])
            && $parts['host'] !== ''
            && ! isset($parts['user'])
            && ! isset($parts['pass'])
            && (! isset($parts['port']) || $parts['port'] === 443);
    }

    public function stream(Request $request, GardenMedia $media): StreamedResponse
    {
        Gate::authorize('view', $media);
        abort_if($media->source_type !== 'upload', 404, 'Este elemento se reproduce desde su enlace externo.');

        $disk = Storage::disk('garden_private');
        abort_unless($disk->exists($media->path), 404, 'El archivo multimedia no está disponible.');

        $size = $disk->size($media->path);
        abort_if($size < 1, 404, 'El archivo multimedia está vacío.');

        $start = 0;
        $end = $size - 1;
        $status = 200;
        $range = $request->header('Range');

        if ($range !== null) {
            if (preg_match('/\Abytes=(\d*)-(\d*)\z/', trim($range), $matches) !== 1
                || ($matches[1] === '' && $matches[2] === '')) {
                return response()->stream(static function (): void {}, 416, [
                    'Content-Range' => "bytes */{$size}",
                    'Accept-Ranges' => 'bytes',
                ]);
            }

            if ($matches[1] === '') {
                $suffixLength = (int) $matches[2];
                if ($suffixLength < 1) {
                    return response()->stream(static function (): void {}, 416, [
                        'Content-Range' => "bytes */{$size}",
                        'Accept-Ranges' => 'bytes',
                    ]);
                }
                $start = max(0, $size - $suffixLength);
            } else {
                $start = (int) $matches[1];
                $end = $matches[2] === '' ? $size - 1 : min((int) $matches[2], $size - 1);
            }

            if ($start >= $size || $start > $end) {
                return response()->stream(static function (): void {}, 416, [
                    'Content-Range' => "bytes */{$size}",
                    'Accept-Ranges' => 'bytes',
                ]);
            }
            $status = 206;
        }

        $length = $end - $start + 1;
        $headers = [
            'Content-Type' => $media->mime_type,
            'Content-Length' => (string) $length,
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'private, no-store',
            'X-Content-Type-Options' => 'nosniff',
            'Referrer-Policy' => 'no-referrer',
            'Content-Disposition' => 'inline',
        ];
        if ($status === 206) {
            $headers['Content-Range'] = "bytes {$start}-{$end}/{$size}";
        }

        return response()->stream(function () use ($disk, $media, $start, $length): void {
            $stream = $disk->readStream($media->path);
            if (! is_resource($stream)) {
                throw new RuntimeException('No se pudo abrir el archivo multimedia privado.');
            }

            try {
                if (fseek($stream, $start) !== 0) {
                    throw new RuntimeException('No se pudo posicionar la lectura del archivo multimedia.');
                }

                $remaining = $length;
                while ($remaining > 0 && ! feof($stream)) {
                    $chunk = fread($stream, min(1024 * 1024, $remaining));
                    if ($chunk === false || $chunk === '') {
                        break;
                    }
                    echo $chunk;
                    $remaining -= strlen($chunk);
                }
                if ($remaining > 0) {
                    throw new RuntimeException('La lectura del archivo multimedia terminó antes de tiempo.');
                }
            } finally {
                fclose($stream);
            }
        }, $status, $headers);
    }

    public function destroy(GardenMedia $media): RedirectResponse
    {
        Gate::authorize('delete', $media);

        $disk = Storage::disk('garden_private');
        if ($media->source_type === 'upload' && $media->path !== null
            && $disk->exists($media->path) && ! $disk->delete($media->path)) {
            throw new RuntimeException('No se pudo retirar el archivo multimedia privado.');
        }
        $media->delete();

        return redirect()->to(route('home').'#entretenimiento')
            ->with('status', 'Archivo retirado del espacio de entretenimiento.');
    }
}
