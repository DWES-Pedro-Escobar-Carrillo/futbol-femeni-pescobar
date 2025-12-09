<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Si l'usuari no està autenticat o no té el rol esperat
        if (! $request->user() || $request->user()->role !== $role) {
            abort(403, 'Accés no autoritzat.');
        }

        return $next($request);
    }
}