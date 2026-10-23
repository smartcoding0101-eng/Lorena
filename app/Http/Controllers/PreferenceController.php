<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PreferenceController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'theme' => ['required', 'in:rose,sage,lavender'],
        ]);

        $request->user()->update([
            'preferences' => array_merge($request->user()->preferences ?? [], $validated),
        ]);

        return redirect()->to(route('home').'#ajustes')->with('status', 'Preferencias guardadas.');
    }
}
