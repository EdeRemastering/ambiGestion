<?php

namespace App\Http\Controllers;

use App\Models\Recurso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class RecursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recursos = DB::table('recurso')
        ->join('estado_recurso', 'recurso.estado', '=', 'estado_recurso.id')
        ->join('ambientes', 'recurso.id_ambiente', '=', 'ambientes.id')
        ->select(
            'recurso.id_recurso',
            'ambientes.alias AS alias_ambiente',
            'recurso.descripcion',
            'recurso.fecha_registro',
            'estado_recurso.nombre AS nombre_estado'
        )
        ->get();

        $recursoPorEstado = DB::table('recurso')
        ->select('estado', DB::raw('count(*) as total'))
        ->groupBy('estado')
        ->get();


        $estados = DB::table('estado_recurso')->select('id', 'nombre')->get();

        $recursosTotal = DB::table('recurso')->count();
        
        return view('recursos.index', compact('recursos', 'estados', 'recursoPorEstado', 'recursosTotal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ambientes = DB::table('ambientes')->select('id', 'alias')->get();
        $estados = DB::table('estado_recurso')->select('id', 'nombre')->get();
        return view('recursos.create', compact('estados', 'ambientes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
        $request->validate([
            'id_ambiente' => 'required|integer',
            'descripcion' => 'required|string',
            'estado' => 'required|integer'
        ]);


            Recurso::create($request->all());
            return redirect()->route('recursos.index')->with('success', 'Recurso creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el recurso.' . $e->getMessage());
        }
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $recurso = DB::table('recurso')
        ->join('estado_recurso', 'recurso.estado', '=', 'estado_recurso.id')
        ->join('ambientes', 'recurso.id_ambiente', '=', 'ambientes.id')
        ->select(
            'recurso.id_recurso',
            'ambientes.alias AS alias_ambiente',
            'recurso.descripcion',
            'recurso.fecha_registro',
            'estado_recurso.nombre AS nombre_estado'
        )
        ->where('recurso.id_recurso', $id)
        ->first();
        return view('recursos.show', compact('recurso'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $recurso = Recurso::findOrFail($id);
        $ambientes = DB::table('ambientes')->select('id', 'alias')->get();
        $estados = DB::table('estado_recurso')->select('id', 'nombre')->get();
        return view('recursos.edit', compact('recurso', 'estados', 'ambientes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
        $request->validate([
            'id_ambiente' => 'required|integer',
            'descripcion' => 'required|string',
            'estado' => 'required|integer'
        ]);
        

            $recurso = Recurso::findOrFail($id);
            $recurso->update($request->all());
            return redirect()->route('recursos.index')->with('success', 'Recurso actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el recurso.' . $e->getMessage());
        }
     
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        try {
        $recurso = Recurso::findOrFail($id);
      
            $recurso->delete();
            return redirect()->route('recursos.index')->with('success', 'Recurso eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el recurso.' . $e->getMessage());
        }
     
    }

    public function generarPDF()
    {

        
        $recursos = DB::table('recurso')
        ->join('estado_recurso', 'recurso.estado', '=', 'estado_recurso.id')
        ->join('ambientes', 'recurso.id_ambiente', '=', 'ambientes.id')
        ->select(
            'recurso.id_recurso',
            'ambientes.alias AS alias_ambiente',
            'recurso.descripcion',
            'recurso.fecha_registro',
            'estado_recurso.nombre AS nombre_estado'
        )
        ->get();

        $recursoPorEstado = DB::table('recurso')
        ->select('estado', DB::raw('count(*) as total'))
        ->groupBy('estado')
        ->get();


        $estados = DB::table('estado_recurso')->select('id', 'nombre')->get();

        $recursosTotal = DB::table('recurso')->count();
        
       // Generar el PDF con los datos y la vista 'pdf.ambientes'
$pdf = PDF::loadView('recursos.pdf', compact('recursos', 'estados', 'recursoPorEstado', 'recursosTotal'));

// Retorna el PDF para que el navegador lo descargue o visualice
return $pdf->stream('recursos.pdf'); // Para mostrar en navegador
// return $pdf->download('ambientes.pdf'); // Para descargar directamente

    }
    
}
