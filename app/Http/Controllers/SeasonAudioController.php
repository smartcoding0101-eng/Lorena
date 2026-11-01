<?php

namespace App\Http\Controllers;

use App\Models\SeasonAudio;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File;

class SeasonAudioController extends Controller
{
    private const ALLOWED_SEASONS = [
        'spring',
        'rain',
        'summer',
        'autumn',
        'winter',
        'stars',
        'bubbles',
        'clear',
    ];

    private const AUDIO_MAX_KILOBYTES = 30720; // 30 MB

    /**
     * Devuelve el catálogo público de audios activos agrupados por estación.
     */
    public function index(Request $request): JsonResponse
    {
        $audios = SeasonAudio::where('is_active', true)
            ->orderBy('season')
            ->orderBy('id', 'desc')
            ->get();

        $grouped = [];
        foreach (self::ALLOWED_SEASONS as $s) {
            $grouped[$s] = [];
        }

        foreach ($audios as $audio) {
            $grouped[$audio->season][] = [
                'id' => $audio->id,
                'title' => $audio->title,
                'url' => $audio->url,
                'file_name' => $audio->original_name,
                'size' => $audio->file_size,
            ];
        }

        return response()->json([
            'seasons' => $grouped,
            'total' => $audios->count(),
        ]);
    }

    /**
     * Endpoint del administrador para listar todos los audios de estaciones (con paginación o filtro).
     */
    public function adminIndex(Request $request): JsonResponse
    {
        $query = SeasonAudio::query()->orderBy('id', 'desc');

        if ($request->filled('season') && in_array($request->season, self::ALLOWED_SEASONS, true)) {
            $query->where('season', $request->season);
        }

        $audios = $query->get();

        return response()->json([
            'audios' => $audios,
            'counts_by_season' => SeasonAudio::selectRaw('season, count(*) as total')
                ->groupBy('season')
                ->pluck('total', 'season'),
        ]);
    }

    /**
     * Subida individual o múltiple de audios por parte del administrador.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'season' => ['required', 'string', 'in:' . implode(',', self::ALLOWED_SEASONS)],
            'title' => ['nullable', 'string', 'max:160'],
            'files' => ['nullable', 'array'],
            'files.*' => [
                'required',
                File::types(['mp3', 'wav', 'ogg', 'oga', 'm4a', 'aac', 'webm'])
                    ->max(self::AUDIO_MAX_KILOBYTES),
            ],
            // Soporte para carga de archivo único ('file')
            'file' => [
                'nullable',
                File::types(['mp3', 'wav', 'ogg', 'oga', 'm4a', 'aac', 'webm'])
                    ->max(self::AUDIO_MAX_KILOBYTES),
            ],
        ]);

        $uploadedFiles = [];
        if ($request->hasFile('files')) {
            $uploadedFiles = $request->file('files');
        } elseif ($request->hasFile('file')) {
            $uploadedFiles = [$request->file('file')];
        }

        if (empty($uploadedFiles)) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Debes seleccionar al menos un archivo de audio válido.'], 422);
            }
            return back()->withErrors(['file' => 'Debes seleccionar al menos un archivo de audio.']);
        }

        $created = [];
        $season = $request->input('season');
        $customTitle = trim((string) $request->input('title', ''));

        foreach ($uploadedFiles as $index => $uploadedFile) {
            $originalName = $uploadedFile->getClientOriginalName();
            $extension = $uploadedFile->getClientOriginalExtension() ?: 'mp3';
            $safeName = Str::uuid()->toString() . '.' . $extension;
            $path = $uploadedFile->storeAs('season_audios/' . $season, $safeName, 'public');

            $title = $customTitle;
            if ($title === '' || count($uploadedFiles) > 1) {
                // Generar título a partir del nombre original
                $title = pathinfo($originalName, PATHINFO_FILENAME);
                $title = str_replace(['_', '-'], ' ', $title);
                $title = ucwords($title);
                if (count($uploadedFiles) > 1 && $customTitle !== '') {
                    $title = $customTitle . ' (' . ($index + 1) . ')';
                }
            }

            $audio = SeasonAudio::create([
                'season' => $season,
                'title' => Str::limit($title, 160),
                'file_path' => $path,
                'original_name' => $originalName,
                'mime_type' => $uploadedFile->getClientMimeType() ?: 'audio/mpeg',
                'file_size' => (int) $uploadedFile->getSize(),
                'is_active' => true,
            ]);

            $created[] = $audio;
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => count($created) === 1
                    ? 'Audio guardado exitosamente.'
                    : count($created) . ' audios cargados exitosamente.',
                'audios' => $created,
            ]);
        }

        return redirect()->to(route('home') . '#admin')
            ->with('status', count($created) . ' audio(s) cargado(s) para la estación ' . $season . '.');
    }

    /**
     * Alternar estado activo/inactivo.
     */
    public function toggleActive(SeasonAudio $seasonAudio): JsonResponse
    {
        $seasonAudio->is_active = !$seasonAudio->is_active;
        $seasonAudio->save();

        return response()->json([
            'success' => true,
            'is_active' => $seasonAudio->is_active,
            'audio' => $seasonAudio,
        ]);
    }

    /**
     * Actualizar título o estación del audio.
     */
    public function update(Request $request, SeasonAudio $seasonAudio): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'season' => ['required', 'string', 'in:' . implode(',', self::ALLOWED_SEASONS)],
        ]);

        $seasonAudio->update($validated);

        return response()->json([
            'success' => true,
            'audio' => $seasonAudio,
        ]);
    }

    /**
     * Eliminar audio del almacenamiento y base de datos.
     */
    public function destroy(SeasonAudio $seasonAudio): JsonResponse|RedirectResponse
    {
        if ($seasonAudio->file_path && Storage::disk('public')->exists($seasonAudio->file_path)) {
            Storage::disk('public')->delete($seasonAudio->file_path);
        }

        $seasonAudio->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Audio eliminado correctamente.',
            ]);
        }

        return redirect()->to(route('home') . '#admin')
            ->with('status', 'Audio eliminado correctamente.');
    }
}
