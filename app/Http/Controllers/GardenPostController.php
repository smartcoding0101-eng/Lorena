<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGardenPostRequest;
use App\Http\Requests\UpdateGardenPostRequest;
use App\Models\GardenPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GardenPostController extends Controller
{
    public function show(string $slug): View
    {
        $post = GardenPost::publishedBlog()->where('slug', $slug)->firstOrFail();

        return view('blog.show', compact('post'));
    }

    public function store(StoreGardenPostRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $request->user()->gardenPosts()->create([
            ...$validated,
            'slug'   => Str::slug($validated['title']) . '-' . Str::lower(Str::random(8)),
            'status' => 'draft',
        ]);

        $screen = $validated['kind'] === 'diary' ? 'diario' : 'blog';

        return redirect()->to(route('home') . "#{$screen}")->with('status', 'Borrador guardado. No es público.');
    }

    public function update(UpdateGardenPostRequest $request, GardenPost $post): RedirectResponse
    {
        Gate::authorize('update', $post);

        $validated = $request->validated();
        $post->update($validated);

        $screen = $post->kind === 'diary' ? 'diario' : 'blog';

        return redirect()->to(route('home') . "#{$screen}")->with('status', 'Entrada actualizada.');
    }

    public function publish(GardenPost $post): RedirectResponse
    {
        Gate::authorize('publish', $post);
        $post->update(['status' => 'published']);

        return redirect()->to(route('home').'#blog')->with('status', 'Entrada publicada en el blog público.');
    }

    public function unpublish(GardenPost $post): RedirectResponse
    {
        Gate::authorize('publish', $post);
        $post->update(['status' => 'draft']);

        return redirect()->to(route('home').'#blog')->with('status', 'Entrada retirada del blog y guardada como borrador.');
    }

    public function destroy(GardenPost $post): RedirectResponse
    {
        Gate::authorize('delete', $post);
        $screen = $post->kind === 'diary' ? 'diario' : 'blog';
        $post->delete();

        return redirect()->to(route('home')."#{$screen}")->with('status', 'Entrada eliminada.');
    }
}
