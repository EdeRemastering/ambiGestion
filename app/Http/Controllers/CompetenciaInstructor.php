<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personas;
use App\Models\Competencia;
use Illuminate\Support\Facades\DB;

class CompetenciaInstructor extends Controller
{
    public function asignar($competencia_id)
    {
        $competencia = Competencia::with('programaFormacion.redConocimiento')->findOrFail($competencia_id);
        $instructores = $competencia->getInstructoresDisponibles();

        return view('competencias.asignar-instructor', compact('competencia', 'instructores'));
    }

    public function guardarAsignacion(Request $request)
    {
        $validatedData = $request->validate([
            'competencia_id' => 'required|exists:competencias,id',
            'instructor_id' => 'required|exists:personas,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'horas_asignadas' => 'required|integer|min:1',
            'horario' => 'required|array'
        ]);

        try {
            $competencia = Competencia::with('programaFormacion.redConocimiento')
                                    ->findOrFail($validatedData['competencia_id']);
            
            // Verificar que el instructor pertenece a la red de conocimiento del programa
            $instructor = Personas::findOrFail($validatedData['instructor_id']);
            if (!$instructor->redesConocimiento->contains($competencia->programaFormacion->red_conocimiento_id)) {
                throw new \Exception('El instructor no pertenece a la red de conocimiento del programa de formación.');
            }

            // Verificar horas disponibles
            if ($competencia->horasDisponiblesParaAsignar() < $validatedData['horas_asignadas']) {
                throw new \Exception('No hay suficientes horas disponibles para asignar.');
            }

            // Guardar la asignación
            $competencia->instructores()->attach($validatedData['instructor_id'], [
                'fecha_inicio' => $validatedData['fecha_inicio'],
                'fecha_fin' => $validatedData['fecha_fin'],
                'horas_asignadas' => $validatedData['horas_asignadas'],
                'horario' => json_encode($validatedData['horario']),
                'estado' => 'activo'
            ]);

            return redirect()->route('competencias.show', $competencia)
                           ->with('success', 'Instructor asignado correctamente');

        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    public function asignarInstructor(Competencia $competencia)
    {
        // Obtener instructores disponibles de la red de conocimiento del programa
        $instructores = Personas::whereHas('user.role', function($q) {
            $q->where('name', 'instructor');
        })->whereHas('redesConocimiento', function($q) use ($competencia) {
            $q->where('red_conocimientos.id', $competencia->programaFormacion->redConocimiento->id);
        })->get();

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
}
