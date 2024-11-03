<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\AmbienteProgramacion;
use App\Models\Ambiente;
use App\Models\Personas;
use App\Models\Ficha;
use App\Models\Jornada;
use App\Models\Competencia;
use App\Models\ResultadoAprendizaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AmbienteProgramacionController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Obtener la fecha de inicio
            $fechaInicio = $request->fecha_inicio ? Carbon::parse($request->fecha_inicio) : Carbon::now();
            $fechaInicio = $fechaInicio->startOfWeek();
            $fechaFin = $fechaInicio->copy()->endOfWeek();
    
            // Debug
            Log::info('Parámetros de búsqueda:', [
                'fecha_inicio' => $fechaInicio->format('Y-m-d'),
                'fecha_fin' => $fechaFin->format('Y-m-d'),
                'ambiente_id' => $request->ambiente_id,
                'instructor_id' => $request->instructor_id
            ]);
    
            // Cargar datos base
            $ambientes = Ambiente::all();
            $instructores = Personas::whereHas('user.role', function($query) {
                $query->where('name', 'instructor');
            })->get();
    
            // Obtener programaciones
            $query = AmbienteProgramacion::with([
                'ambiente',
                'ficha',
                'jornada',
                'competencia',
                'resultadoAprendizaje',
                'instructor'
            ])->whereBetween('fecha', [
                $fechaInicio->format('Y-m-d'),
                $fechaFin->format('Y-m-d')
            ]);
    
            // Verificar la consulta SQL
            Log::info('SQL Query:', [
                'sql' => $query->toSql(),
                'bindings' => $query->getBindings()
            ]);
    
            // Aplicar filtros
            if ($request->filled('ambiente_id')) {
                $query->where('ambiente_id', $request->ambiente_id);
            }
    
            if ($request->filled('instructor_id')) {
                $query->where('persona_id', $request->instructor_id);
            }
    
            $programaciones = $query->get();
    
            // Debug de programaciones encontradas
            Log::info('Programaciones encontradas:', [
                'total' => $programaciones->count(),
                'fechas' => $programaciones->pluck('fecha')->toArray(),
                'ids' => $programaciones->pluck('id')->toArray()
            ]);
    
            // Generar días de la semana
            $diasSemana = [];
            $tempFecha = $fechaInicio->copy();
            for ($i = 0; $i < 7; $i++) {
                $diasSemana[] = $tempFecha->copy();
                $tempFecha->addDay();
            }
    
            // Organizar programaciones por día
            $programacionesPorDia = [];
            foreach ($diasSemana as $dia) {
                $fecha = $dia->format('Y-m-d');
                $programacionesDia = $programaciones->filter(function($prog) use ($fecha) {
                    return $prog->fecha->format('Y-m-d') === $fecha;
                });
                $programacionesPorDia[$fecha] = $programacionesDia;
                
                // Debug de programaciones por día
                Log::info("Programaciones para {$fecha}:", [
                    'cantidad' => $programacionesDia->count(),
                    'ids' => $programacionesDia->pluck('id')->toArray()
                ]);
            }
    
            return view('ambiente-programacion.index', compact(
                'programacionesPorDia',
                'diasSemana',
                'ambientes',
                'instructores',
                'fechaInicio'
            ));
    
        } catch (\Exception $e) {
            Log::error('Error en index:', [
                'mensaje' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Error al cargar las programaciones: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $ambientes = Ambiente::all();
        $fichas = Ficha::all();
        $jornadas = Jornada::all();
        $competencias = Competencia::with('resultadosAprendizaje')->get();
        $instructores = Personas::whereHas('user.role', function($query) {
            $query->where('name', 'instructor');
        })->get();
    
        // Obtener todos los resultados con sus horas asignadas
        $resultadosAprendizaje = ResultadoAprendizaje::select('id', 'codigo', 'descripcion', 'competencia_id', 'intensidad_horaria')
            ->selectRaw('(SELECT COALESCE(SUM(horas_asignadas), 0) FROM ambiente_programacions WHERE resultado_aprendizaje_id = resultado_aprendizajes.id) as horas_programadas')
            ->get()
            ->map(function($resultado) {
                return [
                    'id' => $resultado->id,
                    'codigo' => $resultado->codigo,
                    'descripcion' => $resultado->descripcion,
                    'competencia_id' => $resultado->competencia_id,
                    'intensidad_horaria' => $resultado->intensidad_horaria,
                    'horas_disponibles' => $resultado->intensidad_horaria - $resultado->horas_programadas
                ];
            });
    
        // Generar días de la semana
        $fechaInicio = Carbon::now()->startOfWeek();
        $diasSemana = [];
        for ($i = 0; $i < 7; $i++) {
            $diasSemana[] = $fechaInicio->copy()->addDays($i);
        }
    
        return view('ambiente-programacion.create', compact(
            'ambientes',
            'fichas',
            'jornadas',
            'competencias',
            'instructores',
            'diasSemana',
            'resultadosAprendizaje'
        ));
    }

    public function store(Request $request)
{
    try {
        DB::beginTransaction();

        $programacionesCreadas = 0;

        foreach ($request->programaciones as $index => $programacionData) {
            // Si todos los campos están vacíos, saltar esta iteración
            if (empty($programacionData['ambiente_id']) || 
                empty($programacionData['ficha_id']) || 
                empty($programacionData['jornada_id']) || 
                empty($programacionData['persona_id']) || 
                empty($programacionData['competencia_id']) ||
                empty($programacionData['resultado_aprendizaje_id']) ||
                empty($programacionData['fecha'])) {
                continue;
            }

            // 1. Validar disponibilidad del instructor en la misma jornada
            $instructorEnMismaJornada = AmbienteProgramacion::where([
                'fecha' => $programacionData['fecha'],
                'jornada_id' => $programacionData['jornada_id'],
                'persona_id' => $programacionData['persona_id']
            ])->exists();

            if ($instructorEnMismaJornada) {
                throw new \Exception("El instructor ya tiene una programación para el día " . 
                    Carbon::parse($programacionData['fecha'])->format('d/m/Y') . 
                    " en la jornada seleccionada.");
            }

            // 2. Validar disponibilidad del ambiente en la misma jornada
            $ambienteOcupado = AmbienteProgramacion::where([
                'fecha' => $programacionData['fecha'],
                'jornada_id' => $programacionData['jornada_id'],
                'ambiente_id' => $programacionData['ambiente_id']
            ])->exists();

            if ($ambienteOcupado) {
                throw new \Exception("El ambiente ya está ocupado para el día " . 
                    Carbon::parse($programacionData['fecha'])->format('d/m/Y') . 
                    " en la jornada seleccionada.");
            }

            // 3. Validar que la ficha no tenga otra programación en la misma jornada
            $fichaEnMismaJornada = AmbienteProgramacion::where([
                'fecha' => $programacionData['fecha'],
                'jornada_id' => $programacionData['jornada_id'],
                'ficha_id' => $programacionData['ficha_id']
            ])->exists();

            if ($fichaEnMismaJornada) {
                throw new \Exception("La ficha ya tiene una programación para el día " . 
                    Carbon::parse($programacionData['fecha'])->format('d/m/Y') . 
                    " en la jornada seleccionada.");
            }

            // 4. Validar horas disponibles del resultado de aprendizaje
            $resultado = ResultadoAprendizaje::find($programacionData['resultado_aprendizaje_id']);
            $horasProgramadas = AmbienteProgramacion::where('resultado_aprendizaje_id', $resultado->id)
                ->sum('horas_asignadas');
            
            $horasDisponibles = $resultado->intensidad_horaria - $horasProgramadas;
            
            if ($horasDisponibles < 6) {
                throw new \Exception("El resultado de aprendizaje no tiene suficientes horas disponibles para el día " . 
                    Carbon::parse($programacionData['fecha'])->format('d/m/Y'));
            }

            // Obtener la jornada para las horas
            $jornada = Jornada::findOrFail($programacionData['jornada_id']);

            // Crear la programación
            AmbienteProgramacion::create([
                'ambiente_id' => $programacionData['ambiente_id'],
                'ficha_id' => $programacionData['ficha_id'],
                'jornada_id' => $programacionData['jornada_id'],
                'competencia_id' => $programacionData['competencia_id'],
                'resultado_aprendizaje_id' => $programacionData['resultado_aprendizaje_id'],
                'persona_id' => $programacionData['persona_id'],
                'fecha' => $programacionData['fecha'],
                'hora_inicio' => $jornada->hora_inicio,
                'hora_fin' => $jornada->hora_fin,
                'horas_asignadas' => 6,
                'estado' => 'programado'
            ]);

            $programacionesCreadas++;
        }

        if ($programacionesCreadas === 0) {
            throw new \Exception("Debe completar al menos una programación.");
        }

        DB::commit();

        $mensaje = "Programaciones creadas exitosamente.";
        if (session()->has('warning')) {
            $mensaje .= " " . session('warning');
        }

        if ($request->ajax()) {
            return response()->json(['success' => $mensaje]);
        }

        return redirect()->route('ambiente-programacion.index')
            ->with('success', $mensaje);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error al crear programaciones: ' . $e->getMessage());
        
        if ($request->ajax()) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
        
        return back()
            ->withInput()
            ->with('error', $e->getMessage());
    }
}

    public function getResultados($competenciaId)
    {
        try {
            $resultados = ResultadoAprendizaje::where('competencia_id', $competenciaId)
                ->select('id', 'codigo', 'descripcion', 'intensidad_horaria')
                ->with(['programaciones' => function($query) {
                    $query->select('id', 'resultado_aprendizaje_id', 'horas_asignadas');
                }])
                ->get()
                ->map(function($resultado) {
                    $horasProgramadas = $resultado->programaciones->sum('horas_asignadas');
                    return [
                        'id' => $resultado->id,
                        'codigo' => $resultado->codigo,
                        'descripcion' => $resultado->descripcion,
                        'intensidad_horaria' => $resultado->intensidad_horaria,
                        'horas_programadas' => $horasProgramadas,
                        'horas_disponibles' => $resultado->intensidad_horaria - $horasProgramadas
                    ];
                });
    
            return response()->json($resultados);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $programacion = AmbienteProgramacion::with([
            'ambiente',
            'ficha',
            'jornada',
            'competencia',
            'instructor',
            'resultadoAprendizaje'
        ])->findOrFail($id);

        return view('ambiente-programacion.show', compact('programacion'));
    }

    public function edit($id)
    {
        $programacion = AmbienteProgramacion::findOrFail($id);
        $ambientes = Ambiente::all();
        $fichas = Ficha::all();
        $jornadas = Jornada::all();
        $competencias = Competencia::all();
        $resultados = ResultadoAprendizaje::where('competencia_id', $programacion->competencia_id)->get();
        $instructores = Personas::whereHas('user.role', function($query) {
            $query->where('name', 'instructor');
        })->get();

        return view('ambiente-programacion.edit', compact(
            'programacion',
            'ambientes',
            'fichas',
            'jornadas',
            'competencias',
            'resultados',
            'instructores'
        ));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'ambiente_id' => 'required|exists:ambientes,id',
                'ficha_id' => 'required|exists:fichas,id',
                'jornada_id' => 'required|exists:jornadas,id',
                'competencia_id' => 'required|exists:competencias,id',
                'resultado_aprendizaje_id' => 'required|exists:resultado_aprendizajes,id',
                'persona_id' => 'required|exists:personas,id',
                'fecha' => 'required|date'
            ]);

            $programacion = AmbienteProgramacion::findOrFail($id);
            
            // Realizar todas las validaciones igual que en store
            $existeProgramacion = AmbienteProgramacion::where('id', '!=', $id)
                ->where([
                    'ambiente_id' => $request->ambiente_id,
                    'fecha' => $request->fecha,
                    'jornada_id' => $request->jornada_id
                ])->exists();

            if ($existeProgramacion) {
                throw new \Exception('Ya existe una programación para este ambiente en la fecha y jornada seleccionada');
            }

            // Verificar disponibilidad del instructor
            $instructorOcupado = AmbienteProgramacion::where('id', '!=', $id)
                ->where([
                    'persona_id' => $request->persona_id,
                    'fecha' => $request->fecha,
                    'jornada_id' => $request->jornada_id
                ])->exists();

            if ($instructorOcupado) {
                throw new \Exception('El instructor ya tiene una programación en esta fecha y jornada');
            }

            $jornada = Jornada::findOrFail($request->jornada_id);

            $programacion->update([
                'ambiente_id' => $request->ambiente_id,
                'ficha_id' => $request->ficha_id,
                'jornada_id' => $request->jornada_id,
                'competencia_id' => $request->competencia_id,
                'resultado_aprendizaje_id' => $request->resultado_aprendizaje_id,
                'persona_id' => $request->persona_id,
                'fecha' => $request->fecha,
                'hora_inicio' => $jornada->hora_inicio,
                'hora_fin' => $jornada->hora_fin
            ]);

            DB::commit();
            return redirect()->route('ambiente-programacion.index')
                ->with('success', 'Programación actualizada exitosamente');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar programación: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Error al actualizar la programación: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $programacion = AmbienteProgramacion::findOrFail($id);
            $programacion->delete();

            return redirect()->route('ambiente-programacion.index')
                ->with('success', 'Programación eliminada exitosamente');

        } catch (\Exception $e) {
            Log::error('Error al eliminar programación: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar la programación: ' . $e->getMessage());
        }
    }
}