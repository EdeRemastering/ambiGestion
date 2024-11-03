<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\AmbienteProgramacion;
use App\Models\Ambiente;
use App\Models\Personas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteProgramacionController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $esAdmin = $user?->role?->name === 'admin';
        
        // Obtener datos para los selectores si es admin
        $ambientes = $esAdmin ? Ambiente::orderBy('numero')->get() : collect();
        $instructores = $esAdmin ? Personas::whereHas('user.role', function($q) {
            $q->where('name', 'instructor');
        })->orderBy('pnombre')->get() : collect();

        // Fechas predeterminadas
        $fechaHoy = now()->format('Y-m-d');
        $semanaPredeterminada = now()->startOfWeek()->format('Y-m-d');
        $mesPredeterminado = now()->format('Y-m');

        return view('reportes-programacion.index', compact(
            'esAdmin',
            'ambientes',
            'instructores',
            'fechaHoy',
            'semanaPredeterminada',
            'mesPredeterminado'
        ));
    }

    public function diario(Request $request)
    {
        $fecha = $request->get('fecha', now()->format('Y-m-d'));
        $user = Auth::user();
        $role = $user->role->name;
        $esAdmin = $role === 'admin';

        $query = AmbienteProgramacion::with([
            'ambiente',
            'ficha',
            'jornada',
            'competencia',
            'instructor'
        ])->whereDate('fecha', $fecha);

        // Aplicar filtros según el rol
        switch($role) {
            case 'admin':
                if ($request->filled('ambiente_id')) {
                    $query->where('ambiente_id', $request->ambiente_id);
                }
                if ($request->filled('instructor_id')) {
                    $query->where('persona_id', $request->instructor_id);
                }
                $vista = 'reportes-programacion.diario';
                break;

            case 'instructor':
                $query->where('persona_id', $user->persona->id);
                $vista = 'reportes-programacion.instructor.diario';
                break;

            case 'aprendiz':
                $query->whereHas('ficha', function($q) use ($user) {
                    $q->where('codigo_ficha', $user->persona->codigo_ficha);
                });
                $vista = 'reportes-programacion.aprendiz.diario';
                break;

            default:
                abort(403, 'Rol no autorizado');
        }

        $programaciones = $query->orderBy('hora_inicio')->get();
        
        // Datos adicionales para admin
        $ambientes = $esAdmin ? Ambiente::orderBy('numero')->get() : collect();
        $instructores = $esAdmin ? Personas::whereHas('user.role', function($q) {
            $q->where('name', 'instructor');
        })->orderBy('pnombre')->get() : collect();

        // Generar PDF si se solicita
        if ($request->has('pdf')) {
            $pdf = PDF::loadView($vista . '-pdf', compact(
                'programaciones',
                'fecha',
                'esAdmin'
            ));
            return $pdf->download('programacion-diaria.pdf');
        }

        return view($vista, compact(
            'programaciones',
            'fecha',
            'esAdmin',
            'ambientes',
            'instructores'
        ));
    }

    public function semanal(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio', now()->startOfWeek()->format('Y-m-d'));
        $fechaFin = Carbon::parse($fechaInicio)->endOfWeek()->format('Y-m-d');
        $user = Auth::user();
        $role = $user->role->name;
        $esAdmin = $role === 'admin';

        $query = AmbienteProgramacion::with([
            'ambiente',
            'ficha',
            'jornada',
            'competencia',
            'instructor'
        ])->whereBetween('fecha', [$fechaInicio, $fechaFin]);

        // Aplicar filtros según el rol
        switch($role) {
            case 'admin':
                if ($request->filled('ambiente_id')) {
                    $query->where('ambiente_id', $request->ambiente_id);
                }
                if ($request->filled('instructor_id')) {
                    $query->where('persona_id', $request->instructor_id);
                }
                $vista = 'reportes-programacion.semanal';
                break;

            case 'instructor':
                $query->where('persona_id', $user->persona->id);
                $vista = 'reportes-programacion.instructor.semanal';
                break;

            case 'aprendiz':
                $query->whereHas('ficha', function($q) use ($user) {
                    $q->where('codigo_ficha', $user->persona->codigo_ficha);
                });
                $vista = 'reportes-programacion.aprendiz.semanal';
                break;

            default:
                abort(403, 'Rol no autorizado');
        }

        $programaciones = $query->orderBy('fecha')->orderBy('hora_inicio')->get();
        
        // Agrupar programaciones por día
        $programacionesPorDia = $programaciones->groupBy(function($prog) {
            return Carbon::parse($prog->fecha)->format('Y-m-d');
        });

        // Datos adicionales para admin
        $ambientes = $esAdmin ? Ambiente::orderBy('numero')->get() : collect();
        $instructores = $esAdmin ? Personas::whereHas('user.role', function($q) {
            $q->where('name', 'instructor');
        })->orderBy('pnombre')->get() : collect();

        // Generar PDF si se solicita
        if ($request->has('pdf')) {
            $pdf = PDF::loadView($vista . '-pdf', compact(
                'programacionesPorDia',
                'fechaInicio',
                'fechaFin',
                'esAdmin'
            ));
            return $pdf->download('programacion-semanal.pdf');
        }

        return view($vista, compact(
            'programaciones',
            'programacionesPorDia',
            'fechaInicio',
            'fechaFin',
            'esAdmin',
            'ambientes',
            'instructores'
        ));
    }

    public function mensual(Request $request)
    {
        $mes = $request->get('mes', now()->format('Y-m'));
        
        try {
            $fechaInicio = Carbon::createFromFormat('Y-m', $mes)->startOfMonth();
            $fechaFin = $fechaInicio->copy()->endOfMonth();
        } catch (\Exception $e) {
            $fechaInicio = now()->startOfMonth();
            $fechaFin = now()->endOfMonth();
            $mes = $fechaInicio->format('Y-m');
        }

        $user = Auth::user();
        $role = $user->role->name;
        $esAdmin = $role === 'admin';

        $query = AmbienteProgramacion::with([
            'ambiente',
            'ficha',
            'jornada',
            'competencia',
            'instructor'
        ])->whereBetween('fecha', [
            $fechaInicio->format('Y-m-d'),
            $fechaFin->format('Y-m-d')
        ]);

        // Aplicar filtros según el rol
        switch($role) {
            case 'admin':
                if ($request->filled('ambiente_id')) {
                    $query->where('ambiente_id', $request->ambiente_id);
                }
                if ($request->filled('instructor_id')) {
                    $query->where('persona_id', $request->instructor_id);
                }
                $vista = 'reportes-programacion.mensual';
                break;

            case 'instructor':
                $query->where('persona_id', $user->persona->id);
                $vista = 'reportes-programacion.instructor.mensual';
                break;

            case 'aprendiz':
                $query->whereHas('ficha', function($q) use ($user) {
                    $q->where('codigo_ficha', $user->persona->codigo_ficha);
                });
                $vista = 'reportes-programacion.aprendiz.mensual';
                break;

            default:
                abort(403, 'Rol no autorizado');
        }

        $programaciones = $query->orderBy('fecha')->orderBy('hora_inicio')->get();

        // Agrupar programaciones por día
        $programacionesPorDia = $programaciones->groupBy(function($prog) {
            return Carbon::parse($prog->fecha)->format('Y-m-d');
        });

        // Datos adicionales para admin
        $ambientes = $esAdmin ? Ambiente::orderBy('numero')->get() : collect();
        $instructores = $esAdmin ? Personas::whereHas('user.role', function($q) {
            $q->where('name', 'instructor');
        })->orderBy('pnombre')->get() : collect();

        // Generar PDF si se solicita
        if ($request->has('pdf')) {
            $pdf = PDF::loadView($vista . '-pdf', compact(
                'programacionesPorDia',
                'mes',
                'fechaInicio',
                'esAdmin'
            ));
            return $pdf->download('programacion-mensual.pdf');
        }

        return view($vista, compact(
            'mes',
            'fechaInicio',
            'programaciones',
            'programacionesPorDia',
            'esAdmin',
            'ambientes',
            'instructores'
        ));
    }
}