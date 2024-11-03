<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|array  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Verificar que el usuario esté autenticado
        if (!$request->user()) {
            return redirect('login');
        }

        // Verificar que el usuario tenga persona registrada
        if (!$request->user()->persona) {
            return redirect()->route('personas.create')
                ->with('warning', 'Por favor, complete su registro personal antes de continuar.');
        }

        // Si se pasa un solo rol como string
        if (is_string($roles)) {
            $roles = [$roles];
        }

        // Verificar si el usuario tiene alguno de los roles permitidos
        foreach ($roles as $role) {
            if ($request->user()->hasRole($role)) {
                return $next($request);
            }
        }

        // Si no tiene ningún rol permitido
        abort(403, 'No tiene permisos para acceder a esta sección.');
    }
}