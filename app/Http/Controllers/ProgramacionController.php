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
        // Obtiene todas las programaciones
        $programaciones = DB::table('programaciones')
        ->join('fichas', 'programaciones.ficha', '=', 'fichas.id_ficha')
        ->join('ambientes', 'programaciones.ambiente', '=', 'ambientes.id')
        ->join('personas', 'programaciones.instructor_asignante', '=', 'personas.user_id') // Asegúrate de que esté bien relacionado
        ->join('users', 'personas.user_id', '=', 'users.id')
        ->select(
            'programaciones.id',
            'fichas.nombre AS ficha',
            'ambientes.alias AS ambiente',
            DB::raw("CONCAT(personas.pnombre, ' ', personas.snombre, ' ', personas.papellido, ' ', personas.sapellido) AS nombre_instructor_asignante"), // Concatenación correcta
            'programaciones.hora_inicio',
            'programaciones.hora_fin',
            'programaciones.fecha_inicio',
            'programaciones.fecha_fin',
            'programaciones.estado'
        )
        ->get();

        return view('programaciones.index', compact('programaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $programaciones =  DB::table('programaciones')
        ->join('fichas', 'programaciones.ficha', '=', 'fichas.id_ficha')
        ->join('ambientes', 'programaciones.ambiente', '=', 'ambientes.id')
       // ->join('estado_programacion', 'programaciones.ambientes', '=', 'ambientes.id')
        ->select(
            'programaciones.id',
            'fichas.nombre AS ficha',
            'ambientes.alias AS ambiente',
            'programaciones.instructor_asignante',
            'programaciones.hora_inicio',
            'programaciones.hora_fin',
            'programaciones.fecha_inicio',
            'programaciones.fecha_fin',
            'programaciones.estado',
          
        )
        ->get();   

        $fichas = DB::table('fichas')
        ->join('jornadas', 'fichas.jornada', '=', 'jornadas.id')
        ->select('fichas.*', 'jornadas.nombre as jornada_nombre')
        ->get();

        $instructores = DB::table('personas')->select('*')->get();
        $ambientes = DB::table('ambientes')->select('id', 'alias')->get();
       // En tu controlador
        $dias = DB::table('dias')->select('id', 'nombre')->get();


 
        return view('programaciones.create',compact('programaciones', 'fichas', 'ambientes', 'instructores', 'dias'));
    }

    /**
     * Store a newly created resource in storage.
     */public function store(Request $request)
{
    // Validar los datos
    $validated = $request->validate([
        'ficha' => 'required|exists:fichas,id_ficha',
        'ambiente' => 'required|exists:ambientes,id',
        'hora_inicio' => 'required|date_format:H:i',
        'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        'dias' => 'required|array',
        'dias.*' => 'exists:dias,id',  // Validar que los días existan
        'instructor_dia' => 'required|array', // Validar que se incluyan instructores por día
        'estado' => 'required|in:activo,inactivo',
    ]);

    // Obtener el ID del usuario en sesión que será el instructor asignante
    $user = Auth::user();
    $userId = $user->id;

    // Guardar la programación en la tabla programaciones
    $programacion = Programaciones::create([
        'ficha' => $validated['ficha'],
        'ambiente' => $validated['ambiente'],
        'instructor_asignante' => $userId,  // Guardar el ID del instructor asignante
        'hora_inicio' => $validated['hora_inicio'],
        'hora_fin' => $validated['hora_fin'],
        'fecha_inicio' => $validated['fecha_inicio'],
        'fecha_fin' => $validated['fecha_fin'],
        'estado' => $validated['estado'],
    ]);

    // Guardar en la tabla asignacion_diaria
    foreach ($validated['dias'] as $dia) {
        // Verifica si se asignó un instructor para este día
        if (!empty($validated['instructor_dia'][$dia])) {
            AsignacionesDiarias::create([
                'programacion' => $programacion->id,
                'dia' => $dia,
                'instructor_asignado' => $validated['instructor_dia'][$dia],  // Instructor específico para cada día
                'hora_inicio' => $validated['hora_inicio'],
                'hora_fin' => $validated['hora_fin'],
                'fecha_inicio' => $validated['fecha_inicio'],
                'fecha_fin' => $validated['fecha_fin'],
                'estado' => $validated['estado'],
            ]);
        }
    }

    return redirect()->route('programaciones.index')->with('success', 'Programación creada exitosamente.');
}

    

    /**
     * Display the specified resource.
     */public function show($id)
{
    // Obtener la programación
    $programacion = DB::table('programaciones')
        ->join('fichas', 'programaciones.ficha', '=', 'fichas.id_ficha')
        ->join('ambientes', 'programaciones.ambiente', '=', 'ambientes.id')
        ->join('personas', 'programaciones.instructor_asignante', '=', 'personas.user_id')
        ->join('users', 'personas.user_id', '=', 'users.id')
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
        ->where('programaciones.id', $id)
        ->first();

    // Obtener todos los días de la semana
    $diasSemana = DB::table('dias')->select('id', 'nombre')->get();

    // Obtener las asignaciones diarias para esta programación
    $asignacionesDiarias = DB::table('asignaciones_diarias')
        ->join('personas', 'asignaciones_diarias.instructor_asignado', '=', 'personas.user_id')
        ->where('programacion', $id)
        ->select('asignaciones_diarias.dia', DB::raw("CONCAT(personas.pnombre, ' ', personas.papellido) AS instructor"))
        ->get()
        ->keyBy('dia'); // Usamos keyBy para organizar las asignaciones por día

    return view('programaciones.show', compact('programacion', 'diasSemana', 'asignacionesDiarias'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Editar una programación existente
        $programacion= Programaciones::findOrFail($id);
        $fichas = DB::table('fichas')->select('id_ficha', 'nombre')->get(); 
        
        $ambientes = DB::table('ambientes')->select('id', 'alias')->get(); 
        return view('programaciones.edit', compact('programacion', 'fichas', 'ambientes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validación de los datos
        $request->validate([
            'ficha' => 'required',
            'ambiente' => 'required',
            'instructor_asignante' => 'required',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'estado' => 'required'
        ]);

        // Actualizar la programación
        $programaciones= Programaciones::findOrFail($id);
        $programaciones->update($request->all());

        return redirect()->route('programaciones.index')->with('success', 'Programación actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Eliminar una programación
        $programaciones= Programaciones::findOrFail($id);
        $programaciones->delete();

        return redirect()->route('programaciones.index')->with('success', 'Programación eliminada exitosamente.');
    }
}
