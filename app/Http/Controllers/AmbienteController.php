<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Ambiente;
use App\Models\EstadoAmbiente;
use App\Models\TipoAmbiente;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;

class AmbienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    
    $ambientes = Ambiente::with(['tipoAmbiente', 'estadoAmbiente', 'redConocimiento'])->get();
    $estadisticas = [
        'ambientesPorEstado' => Ambiente::selectRaw('estado_id as estado, count(*) as total')
                                        ->groupBy('estado_id')
                                        ->get(),
        'ambientesTotal' => Ambiente::count()
    ];
    $estados = EstadoAmbiente::all();

    return view('ambientes.index', compact('ambientes', 'estadisticas', 'estados'));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $estados = DB::table('estado_ambiente')->select('id', 'nombre')->get();
        $redes_de_conocimiento = DB::table('red_conocimientos')->select('id', 'nombre')->get();
        $tipos = DB::table('tipo_ambientes')->select('id', 'nombre')->get();
        return view('ambientes.create', compact('estados', 'redes_de_conocimiento', 'tipos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            \Log::info('Datos recibidos:', $request->all());
    
            $request->validate([
                'numero' => 'required',
                'alias' => 'required',
                'capacidad' => 'required',
                'descripcion' => 'required',
                'tipo' => 'required|exists:tipo_ambientes,id',
                'estado' => 'required|exists:estado_ambiente,id',
                'red_de_conocimiento' => 'required|exists:red_conocimientos,id'
            ]);
    
            $ambiente = Ambiente::create([
                'numero' => $request->numero,
                'alias' => $request->alias,
                'capacidad' => $request->capacidad,
                'descripcion' => $request->descripcion,
                'tipo_id' => $request->tipo,
                'estado_id' => $request->estado,
                'red_conocimiento_id' => $request->red_de_conocimiento
            ]);
    
            \Log::info('Ambiente creado:', $ambiente->toArray());
    
            return redirect()->route('ambientes.index')
                ->with('success', 'Ambiente creado exitosamente.');
        } catch (\Exception $e) {
            \Log::error('Error al crear ambiente: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el ambiente: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('ambientes.show', compact('ambiente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $ambiente = Ambiente::findOrFail($id);
            $estados = DB::table('estado_ambiente')->select('id', 'nombre')->get();
            $tipos = DB::table('tipo_ambientes')->select('id', 'nombre')->get();
            // Corregido: cambiado red_de_formacion por red_conocimientos
            $redes_de_conocimiento = DB::table('red_conocimientos')->select('id', 'nombre')->get();
            
            return view('ambientes.edit', compact('ambiente', 'estados', 'redes_de_conocimiento', 'tipos'));
        } catch (\Exception $e) {
            \Log::error('Error en edit: ' . $e->getMessage());
            return redirect()->route('ambientes.index')->with('error', 'No se encontró el ambiente.');
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    try {
        $ambiente = Ambiente::findOrFail($id);
        
        $request->validate([
            'numero' => 'required',
            'alias' => 'required',
            'capacidad' => 'required|numeric',
            'descripcion' => 'required',
            'tipo' => 'required|exists:tipo_ambientes,id',
            'estado' => 'required|exists:estado_ambiente,id',
            'red_de_conocimiento' => 'required|exists:red_conocimientos,id'
        ]);

        $ambiente->update([
            'numero' => $request->numero,
            'alias' => $request->alias,
            'capacidad' => $request->capacidad,
            'descripcion' => $request->descripcion,
            'tipo_id' => $request->tipo,
            'estado_id' => $request->estado,
            'red_conocimiento_id' => $request->red_de_conocimiento
        ]);

        return redirect()->route('ambientes.index')
            ->with('success', 'Ambiente actualizado exitosamente.');
    } catch (\Exception $e) {
        \Log::error('Error al actualizar ambiente: ' . $e->getMessage());
        return redirect()->back()
            ->withInput()
            ->with('error', 'Error al actualizar el ambiente: ' . $e->getMessage());
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        try {
            $ambiente = Ambiente::findOrFail($id);
            $ambiente->delete();
            return redirect()->route('ambientes.index')->with('success', 'Ambiente eliminado exitosamente. ');
      
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el ambiente.' . $e->getMessage());
        }
    }
}