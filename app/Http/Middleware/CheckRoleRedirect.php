<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRoleRedirect
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $requestedPath = $request->path(); // Obtiene la ruta solicitada

            // Definir el prefijo de ruta según el rol
            $prefix = '';
            if ($user->hasRole('admin')) {
                $prefix = 'admin';
            } elseif ($user->hasRole('instructor-lider')) {
                $prefix = 'instructor-lider';
            } elseif ($user->hasRole('instructor')) {
                $prefix = 'instructor';
            } elseif ($user->hasRole('aprendiz')) {
                $prefix = 'aprendiz';
            }

            // Si hay un prefijo y la ruta solicitada no comienza con él
            if ($prefix && !str_starts_with($requestedPath, $prefix)) {
                // Obtener solo el segmento de la ruta (novedades, ambientes, etc.)
                $segments = explode('/', $requestedPath);
                $newPath = $prefix . '/' . end($segments); // Usa solo el último segmento

                // Redirigir a la nueva ruta
                return redirect('/' . $newPath);
            }
        }

        return $next($request);
    }
}
