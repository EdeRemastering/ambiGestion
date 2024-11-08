<?php

namespace App\Http\Controllers;

use App\Models\Novedad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class NovedadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $novedades = DB::table('novedad')
        ->join('estado_novedad', 'novedad.estado', '=', 'estado_novedad.id')
        ->select(
            'novedad.id',
            'novedad.nombre',
            'id_recurso',
            'novedad.descripcion',
            'novedad.fecha_registro',
            'estado_novedad.nombre AS nombre_estado_novedad',
            'novedad.fecha_solucion',
            'novedad.descripcion_solucion'
        )
        ->get();
        

        $novedadesPorEstado = DB::table('novedad')
        ->select('estado', DB::raw('count(*) as total'))
        ->groupBy('estado')
        ->get();

        $estados = DB::table('estado_novedad')->select('id', 'nombre')->get();

        $novedadesTotal = DB::table('novedad')->count();

        return view('novedades.index', compact('novedades', 'novedadesPorEstado', 'estados', 'novedadesTotal'));

     }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   

        $estados = DB::table('estado_novedad')->select('id', 'nombre')->get();
        $recursos = DB::table('recurso')->select('*')->get();

        return view('novedades.create', compact('estados', 'recursos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Muestra todos los datos recibidos desde el formulario y detiene la ejecución.
     
        // Validación de los datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'id_recurso' => 'required|integer',
            'descripcion' => 'required|string',
            'estado' => 'required|integer',
            'fecha_solucion' => 'nullable|date'
        ]);
    
        try {
            // Crear la novedad en la base de datos
            Novedad::create($request->all());
            return redirect()->route('novedades.index')->with('success', 'Novedad creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear la novedad. ' . $e->getMessage());
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $novedad = DB::table('novedad')
        ->join('estado_novedad', 'novedad.estado', '=', 'estado_novedad.id')
        ->select(
            'novedad.id',
            'novedad.nombre',
            'novedad.id_recurso',
            'novedad.descripcion',
            'novedad.fecha_registro',
            'estado_novedad.nombre AS nombre_estado_novedad',
            'novedad.fecha_solucion',
            'novedad.descripcion_solucion'
        )
        ->where('novedad.id', $id)
        ->first();
        return view('novedades.show', compact('novedad'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $novedad = Novedad::findOrFail($id);
        $estados = DB::table('estado_novedad')->select('id', 'nombre')->get();
        $recursos = DB::table('recurso')->select('*')->get();
        return view('novedades.edit', compact('novedad', 'estados', 'recursos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        try {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'id_recurso' => 'required|integer',
            'descripcion' => 'required|string',
            'estado' => 'required|integer',
            'fecha_solucion' => 'nullable|date',
            'descripcion_solucion' => 'nullable|string'
        ]);

  
            $novedad = Novedad::findOrFail($id);
            $novedad->update($request->all());
            return redirect()->route('novedades.index')->with('success', 'Novedad actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar la novedad.' . $e->getMessage());
        }
      
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $novedad = Novedad::findOrFail($id);
            $novedad->delete();
            return redirect()->route('novedades.index')->with('success', 'Novedad eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar la novedad.' . $e->getMessage());
        }
      
    }

    public function generarPDF()
    {

        
        $novedades = DB::table('novedad')
        ->join('estado_novedad', 'novedad.estado', '=', 'estado_novedad.id')
        ->select(
            'novedad.id',
            'novedad.nombre',
            'novedad.descripcion',
            'novedad.fecha_registro',
            'estado_novedad.nombre AS nombre_estado_novedad',
            'novedad.fecha_solucion',
            'novedad.descripcion_solucion'
        )
        ->get();
        

        $novedadesPorEstado = DB::table('novedad')
        ->select('estado', DB::raw('count(*) as total'))
        ->groupBy('estado')
        ->get();

        $estados = DB::table('estado_novedad')->select('id', 'nombre')->get();

        $novedadesTotal = DB::table('novedad')->count();

       // Generar el PDF con los datos y la vista 'pdf.ambientes'
$pdf = PDF::loadView('novedades.pdf', compact('novedades', 'novedadesPorEstado', 'estados', 'novedadesTotal'));

// Retorna el PDF para que el navegador lo descargue o visualice
return $pdf->stream('novedades.pdf'); // Para mostrar en navegador
// return $pdf->download('ambientes.pdf'); // Para descargar directamente

    }
    
}