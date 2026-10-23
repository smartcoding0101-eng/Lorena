<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:1', 'max:120'],
            'description' => ['nullable', 'string', 'max:4000'],
        ]);

        $request->user()->albums()->create($validated);

        return redirect()->to(route('home').'#albumes')->with('status', 'Álbum creado.');
    }

    public function update(Request $request, Album $album): RedirectResponse
    {
        Gate::authorize('update', $album);

        $validated = $request->validate([
            'title' => ['required', 'string', 'min:1', 'max:120'],
            'description' => ['nullable', 'string', 'max:4000'],
        ]);

        $album->update($validated);

        return redirect()->to(route('home').'#albumes')->with('status', 'Álbum actualizado.');
    }

    public function destroy(Album $album): RedirectResponse
    {
        Gate::authorize('delete', $album);

        foreach ($album->photos as $photo) {
            Storage::disk('garden_private')->delete($photo->path);
        }

        $album->delete();

        return redirect()->to(route('home').'#albumes')->with('status', 'Álbum eliminado.');
    }
}
