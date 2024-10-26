<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        // Verifica si el usuario está autenticado y tiene el rol requerido
        if (Auth::check() && Auth::user()->role === $role) {
            return $next($request);
        }

        // Si no tiene el rol, redirige o muestra un mensaje de error
        return redirect('/home')->with('error', 'No tienes acceso a esta página.');
    }
}
