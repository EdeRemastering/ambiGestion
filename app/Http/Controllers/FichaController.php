<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Ficha;
use Illuminate\Http\Request;

class FichaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fichas = DB::table('fichas')
            ->join('programas', 'fichas.id_programa_formacion', '=', 'programas.id') // Ajustado para que sea correcto
            ->join('jornadas', 'fichas.jornada', '=', 'jornadas.id')
            ->select('fichas.*',
            'jornadas.nombre AS jornada',
            'programas.nombre AS programa_nombre')
            ->get();
        return view('fichas.index', compact('fichas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $programas = DB::table('programas')->select('id', 'nombre')->get(); 
        $jornadas = DB::table('jornadas')->select('id', 'nombre')->get();
        return view('fichas.create', compact('programas', 'jornadas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_ficha' => 'required|unique:fichas,id_ficha', // Validación para que id_ficha sea único
            'id_programa_formacion' => 'required',
            'nombre' => 'required',
            'jornada' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date'
        ]);

        Ficha::create($request->all());
        return redirect()->route('fichas.index')->with('success', 'Ficha creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id_ficha)
    {
        $ficha = Ficha::findOrFail($id_ficha);
        return view('fichas.show', compact('ficha'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id_ficha)
    {
        $ficha = Ficha::findOrFail($id_ficha);
        $programas = DB::table('programas')->select('id', 'nombre')->get(); 
        $jornadas = DB::table('jornadas')->select('id', 'nombre')->get();
        return view('fichas.edit', compact('ficha', 'programas', 'jornadas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_ficha)
    {
        $request->validate([
            'id_ficha' => 'required|unique:fichas,id_ficha,' . $id_ficha . ',id_ficha', // Se especifica id_ficha como columna
            'id_programa_formacion' => 'required',
            'nombre' => 'required',
            'jornada' => 'required',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date'
        ]);
    
        $ficha = Ficha::findOrFail($id_ficha);
        $ficha->update($request->all());
        return redirect()->route('fichas.index')->with('success', 'Ficha actualizada exitosamente.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_ficha)
    {
        $ficha = Ficha::findOrFail($id_ficha);
        $ficha->delete();
        return redirect()->route('fichas.index')->with('success', 'Ficha eliminada exitosamente.');
    }
}
