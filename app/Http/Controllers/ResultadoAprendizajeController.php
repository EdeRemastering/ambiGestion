<?php

namespace App\Http\Controllers;

use App\Models\ResultadoAprendizaje;
use App\Models\Competencia;
use Illuminate\Http\Request;

class ResultadoAprendizajeController extends Controller
{
    public function index()
    {
        $resultados = ResultadoAprendizaje::with('competencia')->get();
        return view('resultados_aprendizaje.index', compact('resultados'));
    }

    public function create()
    {
        $competencias = Competencia::all();
        return view('resultados_aprendizaje.create', compact('competencias'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'codigo' => 'required|unique:resultado_aprendizajes',
            'descripcion' => 'required',
            'intensidad_horaria' => 'required|integer|min:1',
            'competencia_id' => 'required|exists:competencias,id',
        ]);

        ResultadoAprendizaje::create($validatedData);

        return redirect()->route('resultados_aprendizaje.index')->with('success', 'Resultado de aprendizaje creado exitosamente.');
    }

    public function show(ResultadoAprendizaje $resultado)
    {
        return view('resultados_aprendizaje.show', compact('resultado'));
    }

    public function edit(ResultadoAprendizaje $resultado)
    {
        $competencias = Competencia::all();
        return view('resultados_aprendizaje.edit', compact('resultado', 'competencias'));
    }

    public function update(Request $request, ResultadoAprendizaje $resultado)
    {
        $validatedData = $request->validate([
            'codigo' => 'required|unique:resultado_aprendizajes,codigo,' . $resultado->id,
            'descripcion' => 'required',
            'intensidad_horaria' => 'required|integer|min:1',
            'competencia_id' => 'required|exists:competencias,id',
        ]);

        $resultado->update($validatedData);

        return redirect()->route('resultados_aprendizaje.index')->with('success', 'Resultado de aprendizaje actualizado exitosamente.');
    }

    public function destroy(ResultadoAprendizaje $resultado)
    {
        $resultado->delete();
        return redirect()->route('resultados_aprendizaje.index')->with('success', 'Resultado de aprendizaje eliminado exitosamente.');
    }
}