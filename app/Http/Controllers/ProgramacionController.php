<?php

namespace App\Http\Controllers;

use App\Models\AsignacionesDiarias;
use App\Models\Programaciones;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProgramacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $programaciones = DB::table('programaciones')
                ->join('fichas', 'programaciones.ficha', '=', 'fichas.id_ficha')
                ->join('ambientes', 'programaciones.ambiente', '=', 'ambientes.id')
                ->leftJoin('personas', 'programaciones.instructor_asignante', '=', 'personas.id')
                ->leftJoin('users', 'personas.user_id', '=', 'users.id')
                ->select(
                    'programaciones.id',
                    'fichas.nombre AS ficha',
                    'ambientes.alias AS ambiente',
                    DB::raw("CONCAT(personas.pnombre, ' ', personas.snombre, ' ', personas.papellido, ' ', personas.sapellido) AS nombre_instructor_asignante"),
                    'programaciones.hora_inicio',
                    'programaciones.hora_fin',
                    'programaciones.fecha_inicio',
                    'programaciones.fecha_fin',
                    'programaciones.estado'
                )
                ->get();

            return view('programaciones.index', compact('programaciones'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al obtener las programaciones. Detalles: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $programaciones = DB::table('programaciones')
                ->join('fichas', 'programaciones.ficha', '=', 'fichas.id_ficha')
                ->join('ambientes', 'programaciones.ambiente', '=', 'ambientes.id')
                ->select(
                    'programaciones.*',
                    'fichas.nombre AS ficha',
                    'ambientes.alias AS ambiente'
                )
                ->get();

            $fichas = DB::table('fichas')
                ->join('jornadas', 'fichas.jornada', '=', 'jornadas.id')
                ->select('fichas.*', 'jornadas.nombre as jornada_nombre')
                ->get();

            $instructores = DB::table('personas')
                ->join('users', 'personas.user_id', '=', 'users.id')
                ->join('roles', 'users.role_id', '=', 'roles.id')
                ->where('roles.name', 'instructor')
                ->select('personas.*')
                ->get();

            $ambientes = DB::table('ambientes')
                ->join('estado_ambiente', 'ambientes.estado', '=', 'estado_ambiente.id')
                ->where('estado_ambiente.nombre', '=', 'disponible')
                ->select('ambientes.id', 'ambientes.alias')
                ->get();

            $dias = DB::table('dias')->select('id', 'nombre')->get();

            return view('programaciones.create', compact('programaciones', 'fichas', 'ambientes', 'instructores', 'dias'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al cargar el formulario de creación. Detalles: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validar los datos
            $validated = $request->validate([
                'ficha' => 'required|exists:fichas,id_ficha',
                'ambiente' => 'required|exists:ambientes,id',
                'hora_inicio' => 'required|date_format:H:i',
                'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
                'dias' => 'required|array',
                'dias.*' => 'exists:dias,id',
                'instructor_dia' => 'required|array',
                'estado' => 'required|in:activo,inactivo',
            ]);

            // Obtener el ID del usuario en sesión
            $userId = Auth::id();

            // Guardar la programación
            $programacion = Programaciones::create([
                'ficha' => $validated['ficha'],
                'ambiente' => $validated['ambiente'],
                'instructor_asignante' => $userId,
                'hora_inicio' => $validated['hora_inicio'],
                'hora_fin' => $validated['hora_fin'],
                'fecha_inicio' => $validated['fecha_inicio'],
                'fecha_fin' => $validated['fecha_fin'],
                'estado' => $validated['estado'],
            ]);

            // Guardar asignaciones diarias
            foreach ($validated['dias'] as $dia) {
                if (!empty($validated['instructor_dia'][$dia])) {
                    AsignacionesDiarias::create([
                        'programacion' => $programacion->id,
                        'dia' => $dia,
                        'instructor_asignado' => $validated['instructor_dia'][$dia],
                        'hora_inicio' => $validated['hora_inicio'],
                        'hora_fin' => $validated['hora_fin'],
                        'fecha_inicio' => $validated['fecha_inicio'],
                        'fecha_fin' => $validated['fecha_fin'],
                        'estado' => $validated['estado'],
                    ]);
                }
            }

            return redirect()->route('programaciones.index')->with('success', 'Programación creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear la programación. Detalles: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $programacion = DB::table('programaciones')
                ->join('fichas', 'programaciones.ficha', '=', 'fichas.id_ficha')
                ->join('ambientes', 'programaciones.ambiente', '=', 'ambientes.id')
                ->join('personas', 'programaciones.instructor_asignante', '=', 'personas.id')
                ->join('users', 'personas.user_id', '=', 'users.id')
                ->select(
                    'programaciones.*',
                    'fichas.nombre AS ficha',
                    'ambientes.alias AS ambiente',
                    DB::raw("CONCAT(personas.pnombre, ' ', personas.snombre, ' ', personas.papellido, ' ', personas.sapellido) AS nombre_instructor_asignante")
                )
                ->where('programaciones.id', $id)
                ->first();

            $diasSemana = DB::table('dias')->select('id', 'nombre')->get();

            $asignacionesDiarias = DB::table('asignaciones_diarias')
                ->join('personas', 'asignaciones_diarias.instructor_asignado', '=', 'personas.id')
                ->where('asignaciones_diarias.programacion', $id)
                ->select('asignaciones_diarias.dia', DB::raw("CONCAT(personas.pnombre, ' ', personas.papellido) AS instructor"))
                ->pluck('instructor', 'dia');

            return view('programaciones.show', compact('programacion', 'diasSemana', 'asignacionesDiarias'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al mostrar la programación. Detalles: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $programacion = DB::table('programaciones')
                ->join('fichas', 'programaciones.ficha', '=', 'fichas.id_ficha')
                ->join('ambientes', 'programaciones.ambiente', '=', 'ambientes.id')
                ->where('programaciones.id', $id)
                ->select(
                    'programaciones.*',
                    'fichas.nombre AS ficha_nombre',
                    'ambientes.alias AS ambiente_alias'
                )
                ->first();

            $fichas = DB::table('fichas')
                ->join('jornadas', 'fichas.jornada', '=', 'jornadas.id')
                ->select('fichas.*', 'jornadas.nombre as jornada_nombre')
                ->get();

            $ambientes = DB::table('ambientes')->select('id', 'alias')->get();
            $dias = DB::table('dias')->select('id', 'nombre')->get();
            $instructores = DB::table('personas')->select('id', 'pnombre', 'snombre', 'papellido', 'sapellido')->get();

            $asignacionesDiarias = DB::table('asignaciones_diarias')
                ->where('programacion', $id)
                ->pluck('instructor_asignado', 'dia')
                ->toArray();

            return view('programaciones.edit', compact(
                'programacion', 
                'fichas', 
                'ambientes', 
                'dias', 
                'instructores', 
                'asignacionesDiarias'
            ));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al cargar el formulario de edición. Detalles: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'ficha' => 'required|exists:fichas,id_ficha',
                'ambiente' => 'required|exists:ambientes,id',
                'hora_inicio' => 'required|date_format:H:i',
                'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
                'dias' => 'required|array',
                'dias.*' => 'exists:dias,id',
                'instructor_dia' => 'required|array',
                'estado' => 'required|in:activo,inactivo',
            ]);

            $programacion = Programaciones::findOrFail($id);
            $programacion->update([
                'ficha' => $validated['ficha'],
                'ambiente' => $validated['ambiente'],
                'hora_inicio' => $validated['hora_inicio'],
                'hora_fin' => $validated['hora_fin'],
                'fecha_inicio' => $validated['fecha_inicio'],
                'fecha_fin' => $validated['fecha_fin'],
                'estado' => $validated['estado'],
            ]);

            AsignacionesDiarias::where('programacion', $programacion->id)->delete();

            foreach ($validated['dias'] as $dia) {
                if (!empty($validated['instructor_dia'][$dia])) {
                    AsignacionesDiarias::create([
                        'programacion' => $programacion->id,
                        'dia' => $dia,
                        'instructor_asignado' => $validated['instructor_dia'][$dia],
                        'hora_inicio' => $validated['hora_inicio'],
                        'hora_fin' => $validated['hora_fin'],
                        'fecha_inicio' => $validated['fecha_inicio'],
                        'fecha_fin' => $validated['fecha_fin'],
                        'estado' => $validated['estado'],
                    ]);
                }
            }

            return redirect()->route('programaciones.index')->with('success', 'Programación actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar la programación. Detalles: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $programacion = Programaciones::findOrFail($id);
            $programacion->delete();

            return redirect()->route('programaciones.index')->with('success', 'Programación eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar la programación. Detalles: ' . $e->getMessage());
        }
    }
}
