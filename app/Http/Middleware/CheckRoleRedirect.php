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
            $requestedPath = $request->path();

            // Excepciones para rutas de programaciones
            $allowedProgramacionesPaths = ['admin/programaciones', 'instructor-lider/programaciones'];
            foreach ($allowedProgramacionesPaths as $allowedPath) {
                if (str_starts_with($requestedPath, $allowedPath)) {
                    return $next($request); // Permite acceso directo sin redirección
                }
            }

            // Definir prefijo de ruta según el rol
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

            // Redirección si el prefijo es obligatorio y la ruta solicitada no lo contiene
            if ($prefix && !str_starts_with($requestedPath, $prefix)) {
                session()->reflash();
                
                // Redirecciona con el nuevo prefijo
                $segments = explode('/', $requestedPath);
                array_shift($segments);
                $newPath = $prefix . '/' . implode('/', $segments);
            
                return redirect('/' . $newPath);
            }
        }

        return $next($request);
    }
}
