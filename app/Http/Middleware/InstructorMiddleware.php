<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InstructorMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->hasRole('instructor')) {
            return $next($request);
        }

   

        abort(403, 'Acceso no autorizado. Se requieren permisos de instructor.');
    }
}
