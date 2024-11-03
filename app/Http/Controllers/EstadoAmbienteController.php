<?php

namespace App\Http\Controllers;

use App\Models\EstadoAmbiente;
use Illuminate\Http\Request;

class EstadoAmbienteController extends Controller
{
    public function index()
    {
        $estados = EstadoAmbiente::all();
        return view('estado-ambientes.index', compact('estados'));
    }

    public function create()
    {
        return view('estado-ambientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:estado_ambiente'
        ]);

        EstadoAmbiente::create($request->all());
        return redirect()->route('estado-ambientes.index')
            ->with('success', 'Estado de ambiente creado exitosamente.');
    }

    public function edit(EstadoAmbiente $estadoAmbiente)
    {
        return view('estado-ambientes.edit', compact('estadoAmbiente'));
    }

    public function update(Request $request, EstadoAmbiente $estadoAmbiente)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:estado_ambiente,nombre,' . $estadoAmbiente->id
        ]);

        $estadoAmbiente->update($request->all());
        return redirect()->route('estado-ambientes.index')
            ->with('success', 'Estado de ambiente actualizado exitosamente.');
    }

    public function destroy(EstadoAmbiente $estadoAmbiente)
    {
        try {
            $estadoAmbiente->delete();
            return redirect()->route('estado-ambientes.index')
                ->with('success', 'Estado de ambiente eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('estado-ambientes.index')
                ->with('error', 'No se puede eliminar este estado porque está en uso.');
        }
    }
}