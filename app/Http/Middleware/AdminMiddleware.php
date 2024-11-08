<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('api/*')) {
            return $next($request);
        }
        
        if ($request->user() && $request->user()->hasRole('admin')) {
            return $next($request);
        }

        abort(403, 'Acceso no autorizado. Se requieren permisos de administrador.');
    }
}