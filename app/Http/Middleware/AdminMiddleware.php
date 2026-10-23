<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if (!$user || (!$user->is_admin && !in_array($user->id, [1, 2], true))) {
            abort(403, 'Acceso restringido al administrador.');
        }

        return $next($request);
    }
}