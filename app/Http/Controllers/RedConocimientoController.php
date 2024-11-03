<?php

namespace App\Http\Controllers;

use App\Models\RedConocimiento;
use Illuminate\Http\Request;

class RedConocimientoController extends Controller
{
    public function index()
    {
        $redesConocimiento = RedConocimiento::all();
        return view('red_conocimiento.index', compact('redesConocimiento'));
    }

    public function create()
    {
        return view('red_conocimiento.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'codigo' => 'required|string|unique:red_conocimientos,codigo',
        ]);

        RedConocimiento::create($validatedData);

        return redirect()->route('red_conocimiento.index')
            ->with('success', 'Red de Conocimiento creada exitosamente.');
    }

    public function show(RedConocimiento $redConocimiento)
    {
        return view('red_conocimiento.show', compact('redConocimiento'));
    }

    public function edit(RedConocimiento $redConocimiento)
    {
        return view('red_conocimiento.edit', compact('redConocimiento'));
    }

    public function update(Request $request, RedConocimiento $redConocimiento)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'codigo' => 'required|string|unique:red_conocimientos,codigo,' . $redConocimiento->id,
        ]);

        $redConocimiento->update($validatedData);

        return redirect()->route('red_conocimiento.index')
            ->with('success', 'Red de Conocimiento actualizada exitosamente.');
    }

    public function destroy(RedConocimiento $redConocimiento)
    {
        $redConocimiento->delete();

        return redirect()->route('red_conocimiento.index')
            ->with('success', 'Red de Conocimiento eliminada exitosamente.');
    }
}