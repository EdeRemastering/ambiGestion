<?php

namespace App\Http\Controllers;

use App\Models\ProgramaFormacion;
use Illuminate\Http\Request;

class ProgramaFormacionController extends Controller
{
    public function index()
    {
        $programas = ProgramaFormacion::all();
        return view('programas.index', compact('programas'));
    }

    public function create()
    {
        return view('programas.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|unique:programa__formacions,codigo',
            'version' => 'required|string',
            'descripcion' => 'required|string',
            'duracion_meses' => 'required|integer|min:1',
        ]);

        ProgramaFormacion::create($validatedData);

        return redirect()->route('programas.index')
            ->with('success', 'Programa de formación creado exitosamente.');
    }
    public function show($id)
    {
        $programa = ProgramaFormacion::findOrFail($id);
        return view('programas.show', compact('programa'));
    }

    public function edit($id)
    {
        $programa = ProgramaFormacion::findOrFail($id);
        return view('programas.edit', compact('programa'));
    }

    public function update(Request $request, $id)
    {
        $programa = ProgramaFormacion::findOrFail($id);
        
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|unique:programa__formacions,codigo,' . $id,
            'version' => 'required|string',
            'descripcion' => 'required|string',
            'duracion_meses' => 'required|integer|min:1',
        ]);

        $programa->update($validatedData);

        return redirect()->route('programas.index')
            ->with('success', 'Programa de formación actualizado exitosamente.');
    }

    public function destroy(ProgramaFormacion $programa)
    {
        try {
            $programa->delete();
            return redirect()->route('programas.index')->with('success', 'Programa de formación eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('programas.index')->with('error', 'No se pudo eliminar el programa de formación.');
        }
    }

    public function buscar(Request $request)
    {
        $query = $request->get('query');
        $programas = ProgramaFormacion::where('nombre', 'LIKE', "%{$query}%")
                                       ->orWhere('codigo', 'LIKE', "%{$query}%")
                                       ->get();
        return view('programas.index', compact('programas'));
    }
}