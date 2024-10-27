<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RolePrefixMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Verifica si hay un usuario autenticado
        if ($user) {
            // Determina el prefijo según el rol
            switch ($user->role) {
                case 'admin':
                    $prefix = 'admin';
                    break;
                case 'instructor_lider':
                    $prefix = 'instructor-lider';
                    break;
                case 'instructor':
                    $prefix = 'instructor';
                    break;
                case 'aprendiz':
                    $prefix = 'aprendiz';
                    break;
                default:
                    return redirect('/dashboard'); // Redirigir a una ruta por defecto si no hay rol coincidente
            }

            // Verifica si la URL actual comienza con '/home'
            if ($request->is('home/*')) {
                // Construye la nueva ruta
                $newPath = str_replace('dashboard', $prefix, $request->path());

                // Redirige a la nueva ruta
                return redirect()->to($newPath);
            }
        }

        return $next($request);
    }
}
