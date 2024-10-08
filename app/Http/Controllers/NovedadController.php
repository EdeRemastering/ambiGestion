<?php

namespace App\Http\Controllers;

use App\Models\Novedad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'novedad.descripcion',
            'novedad.fecha_registro',
            'estado_novedad.nombre AS nombre_estado_novedad',
            'novedad.fecha_solucion'
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
        return view('novedades.create', compact('estados'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|integer',
            'fecha_solucion' => 'nullable|datetime'
        ]);



            Novedad::create($request->all());
            return redirect()->route('novedades.index')->with('success', 'Novedad creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear la novedad.' . $e->getMessage());
        }
      
    }

    /**
     * Display the specified resource.
     */
    public function show(Novedad $novedad)
    {
        return view('novedades.show', compact('novedad'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $novedad = Novedad::findOrFail($id);
        $estados = DB::table('estado_novedad')->select('id', 'nombre')->get();
        return view('novedades.edit', compact('novedad', 'estados'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        try {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|integer',
            'fecha_solucion' => 'nullable|date'
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
}