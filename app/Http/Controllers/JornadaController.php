<?php

namespace App\Http\Controllers;

use App\Models\Jornada;
use Illuminate\Http\Request;

class JornadaController extends Controller
{
    public function index()
    {
        $jornadas = Jornada::all();
        return view('jornadas.index', compact('jornadas'));
    }

    public function create()
    {
        return view('jornadas.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'hora_inicio' => 'required',
            'hora_fin' => 'required|after:hora_inicio',
        ]);

        Jornada::create($validatedData);

        return redirect()->route('jornadas.index')->with('success', 'Jornada creada exitosamente.');
    }

    public function show(Jornada $jornada)
    {
        return view('jornadas.show', compact('jornada'));
    }

    public function edit(Jornada $jornada)
    {
        return view('jornadas.edit', compact('jornada'));
    }

    public function update(Request $request, Jornada $jornada)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'hora_inicio' => 'required',
            'hora_fin' => 'required|after:hora_inicio',
        ]);

        $jornada->update($validatedData);

        return redirect()->route('jornadas.index')->with('success', 'Jornada actualizada exitosamente.');
    }

    public function destroy(Jornada $jornada)
    {
        $jornada->delete();
        return redirect()->route('jornadas.index')->with('success', 'Jornada eliminada exitosamente.');
    }
}