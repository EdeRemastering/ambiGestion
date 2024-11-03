<?php

namespace App\Http\Controllers;

use App\Models\Competencia;
use App\Models\ProgramaFormacion;
use App\Models\Personas;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CompetenciaController extends Controller
{
    public function index()
{
    $competencias = Competencia::with(['programaFormacion', 'resultadosAprendizaje'])->get();
    return view('competencias.index', compact('competencias'));
}

    public function create()
    {
        $programasFormacion = ProgramaFormacion::all();
        return view('competencias.create', compact('programasFormacion'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'codigo' => 'required|unique:competencias',
            'descripcion' => 'required',
            'programa_formacion_id' => 'required|exists:programa__formacions,id',
            'duracion_horas' => 'required|integer|min:1',
        ]);

        Competencia::create($validatedData);

        return redirect()->route('competencias.index')->with('success', 'Competencia creada exitosamente.');
    }

    public function show(Competencia $competencia)
    {
        $horasDisponibles = $competencia->horasDisponibles();
        return view('competencias.show', compact('competencia', 'horasDisponibles'));
    }

    public function edit(Competencia $competencia)
{
    $programasFormacion = ProgramaFormacion::all();
    return view('competencias.edit', compact('competencia', 'programasFormacion'));
}

    public function update(Request $request, Competencia $competencia)
    {
        $validatedData = $request->validate([
            'codigo' => 'required|unique:competencias,codigo,' . $competencia->id,
            'descripcion' => 'required',
            'programa_formacion_id' => 'required|exists:programa__formacions,id',
            'duracion_horas' => 'required|integer|min:1',
        ]);

        $competencia->update($validatedData);

        return redirect()->route('competencias.index')->with('success', 'Competencia actualizada exitosamente.');
    }

    public function destroy(Competencia $competencia)
    {
        $competencia->delete();
        return redirect()->route('competencias.index')->with('success', 'Competencia eliminada exitosamente.');
    }
    public function distribuirHoras(Competencia $competencia)
    {
        try {
            DB::transaction(function () use ($competencia) {
                if (!$competencia->distribuirHorasAutomaticamente()) {
                    throw new \Exception('No hay resultados de aprendizaje para distribuir horas.');
                }
            });

            return redirect()
                ->route('competencias.show', $competencia)
                ->with('success', 'Horas distribuidas exitosamente');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

public function asignarInstructor(Competencia $competencia)
{
    // Obtener instructores disponibles
    $instructores = Personas::whereHas('user.role', function($q) {
        $q->where('name', 'instructor');
    })->whereHas('redesConocimiento', function($q) use ($competencia) {
        $q->where('red_conocimientos.id', $competencia->programaFormacion->redConocimiento->id);
    })
    ->select('personas.*') // Especificamos la tabla para evitar ambigüedad
    ->with(['user', 'redesConocimiento']) // Eager loading para mejor rendimiento
    ->get();

    return view('competencias.asignar-instructor', compact('competencia', 'instructores'));
}

public function guardarAsignacionInstructor(Request $request, Competencia $competencia)
{
    $validatedData = $request->validate([
        'instructor_id' => 'required|exists:personas,id',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after:fecha_inicio',
        'horas_asignadas' => 'required|integer|min:1',
        'horario' => 'required|array'
    ]);

    try {
        DB::transaction(function () use ($competencia, $validatedData) {
            // Verificar horas disponibles
            if ($competencia->horasDisponiblesParaAsignar() < $validatedData['horas_asignadas']) {
                throw new \Exception('No hay suficientes horas disponibles para asignar.');
            }

            // Verificar que el instructor pertenece a la red de conocimiento
            $instructor = Personas::findOrFail($validatedData['instructor_id']);
            if (!$instructor->redesConocimiento->contains($competencia->programaFormacion->redConocimiento->id)) {
                throw new \Exception('El instructor no pertenece a la red de conocimiento del programa.');
            }

            $competencia->instructores()->attach($validatedData['instructor_id'], [
                'fecha_inicio' => $validatedData['fecha_inicio'],
                'fecha_fin' => $validatedData['fecha_fin'],
                'horas_asignadas' => $validatedData['horas_asignadas'],
                'horario' => json_encode($validatedData['horario']),
                'estado' => 'activo'
            ]);
        });

        return redirect()->route('competencias.show', $competencia)
                       ->with('success', 'Instructor asignado correctamente');

    } catch (\Exception $e) {
        return back()
            ->withErrors(['error' => $e->getMessage()])
            ->withInput();
    }
}

public function horasDisponiblesParaAsignar(): float
{
    $horasAsignadas = $this->instructores()
        ->wherePivot('estado', 'activo')
        ->sum('horas_asignadas') ?? 0;
    
    return $this->duracion_horas - $horasAsignadas;
}
}