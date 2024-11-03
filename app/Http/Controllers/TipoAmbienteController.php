<?php

namespace App\Http\Controllers;

use App\Models\TipoAmbiente;
use Illuminate\Http\Request;

class TipoAmbienteController extends Controller
{
    public function index()
    {
        $tiposAmbiente = TipoAmbiente::all();
        return view('tipo-ambientes.index', compact('tiposAmbiente'));
    }

    public function create()
    {
        return view('tipo-ambientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:tipo_ambientes',
        ]);

        TipoAmbiente::create($request->all());

        return redirect()->route('tipo-ambientes.index')
            ->with('success', 'Tipo de ambiente creado exitosamente.');
    }

    public function show(TipoAmbiente $tipoAmbiente)
    {
        return view('tipo-ambientes.show', compact('tipoAmbiente'));
    }

    public function edit(TipoAmbiente $tipoAmbiente)
    {
        return view('tipo-ambientes.edit', compact('tipoAmbiente'));
    }

    public function update(Request $request, TipoAmbiente $tipoAmbiente)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:tipo_ambientes,nombre,' . $tipoAmbiente->id,
        ]);

        $tipoAmbiente->update($request->all());

        return redirect()->route('tipo-ambientes.index')
            ->with('success', 'Tipo de ambiente actualizado exitosamente.');
    }

    public function destroy(TipoAmbiente $tipoAmbiente)
    {
        $tipoAmbiente->delete();

        return redirect()->route('tipo-ambientes.index')
            ->with('success', 'Tipo de ambiente eliminado exitosamente.');
    }
}