<?php

namespace App\Http\Controllers;

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

        $fichas = DB::table('fichas')->select('id_ficha', 'nombre')->get(); 
        $instructores = DB::table('personas')->select('*')->get();
        $ambientes = DB::table('ambientes')->select('id', 'alias')->get();
       // En tu controlador
        $dias = DB::table('dias')->select('id', 'nombre')->get();


 
        return view('programaciones.create',compact('programaciones', 'fichas', 'ambientes', 'instructores', 'dias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Obtener el ID del usuario autenticado (instructor)
    $userId = Auth::id(); // Obtiene el ID del usuario autenticado

    // Validación de los datos
    $request->validate([
        'ficha' => 'required',
        'ambiente' => 'required',
        'hora_inicio' => 'required',
        'hora_fin' => 'required',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date',
        'estado' => 'required'
    ]);

    // Crear un array con los datos del request
    $data = $request->all();

    // Asignar automáticamente el ID del instructor al campo instructor_asignante
    $data['instructor_asignante'] = $userId; // Asignar el ID del usuario autenticado

    // Crear la nueva programación con los datos, incluyendo el ID del instructor
    Programaciones::create($data);

    return redirect()->route('programaciones.index')->with('success', 'Programación creada exitosamente.');
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Mostrar una programación específica
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
        ->where('programaciones.id', $id) // Filtra por el ID de la programación
        ->first(); // O usa ->get() si quieres obtener una colección de registros
    
            
        $fichas = DB::table('fichas')->select('id_ficha', 'nombre')->get(); 
        
        $ambientes = DB::table('ambientes')->select('id', 'alias')->get(); 

        return view('programaciones.show', compact('programacion', 'ambientes', 'fichas'));
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
