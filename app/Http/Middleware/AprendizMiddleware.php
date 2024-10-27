<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AprendizMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->hasRole('aprendiz')) {
            return $next($request);
        }


        abort(403, 'Acceso no autorizado. Se requieren permisos de aprendiz.');
    }
}