<?php

namespace App\Http\Controllers;

use App\Models\Competencia;
use App\Models\ProgramaFormacion;
use Illuminate\Http\Request;

class CompetenciaController extends Controller
{
    public function index()
    {
        $competencias = Competencia::with('programaFormacion')->get();
        return view('competencias.index', compact('competencias'));
    }

    public function create()
    {
        $programas = ProgramaFormacion::all();
        return view('competencias.create', compact('programas'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'codigo' => 'required|unique:competencias',
            'descripcion' => 'required',
            'programa_formacion_id' => 'required|exists:programa__formacions,id',
        ]);

        Competencia::create($validatedData);

        return redirect()->route('competencias.index')->with('success', 'Competencia creada exitosamente.');
    }

    public function show(Competencia $competencia)
    {
        return view('competencias.show', compact('competencia'));
    }

    public function edit(Competencia $competencia)
    {
        $programas = ProgramaFormacion::all();
        return view('competencias.edit', compact('competencia', 'programas'));
    }

    public function update(Request $request, Competencia $competencia)
    {
        $validatedData = $request->validate([
            'codigo' => 'required|unique:competencias,codigo,' . $competencia->id,
            'descripcion' => 'required',
            'programa_formacion_id' => 'required|exists:programa__formacions,id',
        ]);

        $competencia->update($validatedData);

        return redirect()->route('competencias.index')->with('success', 'Competencia actualizada exitosamente.');
    }

    public function destroy(Competencia $competencia)
    {
        $competencia->delete();
        return redirect()->route('competencias.index')->with('success', 'Competencia eliminada exitosamente.');
    }
}