<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureRole
{
    /**
     * Manejar una solicitud entrante.
     *
     * Uso: ->middleware('role:admin') o múltiples: 'role:admin,secretaria'
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }

        $userRole = $user->rol ?? null;
        if (empty($roles)) {
            return $next($request);
        }

        if (!in_array($userRole, $roles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
