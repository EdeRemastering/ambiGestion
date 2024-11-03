<?php

namespace App\Http\Controllers;

use App\Models\ProgramaFormacion;
use App\Models\RedConocimiento;
use Illuminate\Http\Request;

class ProgramaFormacionController extends Controller
{
    public function index()
    {
        $programas = ProgramaFormacion::with('redConocimiento')->get();
        return view('programas.index', compact('programas'));
    }

    public function create()
    {
        $redesConocimiento = RedConocimiento::all();
        return view('programas.create', compact('redesConocimiento'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|unique:programa__formacions,codigo',
            'version' => 'required|string',
            'descripcion' => 'required|string',
            'duracion_meses' => 'required|integer|min:1',
            'red_conocimiento_id' => 'required|exists:red_conocimientos,id',
        ]);

        ProgramaFormacion::create($validatedData);

        return redirect()->route('programas.index')
            ->with('success', 'Programa de Formación creado exitosamente.');
    }
    public function show(ProgramaFormacion $programa)
    {
        return view('programas.show', compact('programa'));
    }


    public function edit(ProgramaFormacion $programa)
    {
        $redesConocimiento = RedConocimiento::all();
        return view('programas.edit', compact('programa', 'redesConocimiento'));
    }

    public function update(Request $request, ProgramaFormacion $programa)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|unique:programa__formacions,codigo,' . $programa->id,
            'version' => 'required|string',
            'descripcion' => 'required|string',
            'duracion_meses' => 'required|integer|min:1',
            'red_conocimiento_id' => 'required|exists:red_conocimientos,id',
        ]);

        $programa->update($validatedData);

        return redirect()->route('programas.index')
            ->with('success', 'Programa de Formación actualizado exitosamente.');
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
    public function getProgramasPorRed(RedConocimiento $redConocimiento)
{
    $programas = $redConocimiento->programasFormacion;
    return response()->json($programas);
}
}