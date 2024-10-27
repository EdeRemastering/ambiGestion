<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRoleRedirect
{
    public function handle($request, Closure $next)
    {
        // Verifica si el usuario está autenticado
        if (Auth::check()) {
            $user = $request->user();

            // Redirección para el rol "admin"
            if ($user->hasRole('admin')) {
                if ($request->is('instructor-lider/*') || $request->is('instructor/*') || $request->is('aprendiz/*')) {
                    return redirect('/admin');
                }
            }

            // Redirección para el rol "instructor_lider"
            if ($user->hasRole('instructor_lider')) {
                if ($request->is('admin/*')) {
                    return redirect('/instructor-lider');
                }
            }

            // Redirección para el rol "instructor"
            if ($user->hasRole('instructor')) {
                if ($request->is('admin/*') || $request->is('instructor-lider/*')) {
                    return redirect('/instructor');
                }
            }

            // Redirección para el rol "aprendiz"
            if ($user->hasRole('aprendiz')) {
                if ($request->is('admin/*') || $request->is('instructor-lider/*') || $request->is('instructor/*')) {
                    return redirect('/aprendiz');
                }
            }
        }

        return $next($request);
    }
}
