<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        // Permitimos acceso si el rol coincide o si es 'admin' (superusuario)
        // Nota: Asegúrate de que en tu BD el rol de administrador sea 'admin' o 'administrador'.
        // Aquí asumo 'admin' por convención, cámbialo a 'administrador' si tu seeder lo pone así.
        $userRole = Auth::user()->role;
        
        if ($userRole !== $role && $userRole !== 'admin' && $userRole !== 'administrador') {
            abort(403, 'No tienes permisos para acceder a este recurso.');
        }

        return $next($request);
    }
}