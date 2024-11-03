<?php

namespace App\Http\Controllers;

use App\Models\Competencia;
use App\Models\Personas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompetenciaInstructorController extends Controller
{
    public function asignar($competencia_id)
    {
        $competencia = Competencia::with('programaFormacion.redConocimiento')->findOrFail($competencia_id);
        
        // Obtener instructores disponibles
        $instructores = Personas::whereHas('user.role', function($q) {
            $q->where('name', 'instructor');
        })->whereHas('redesConocimiento', function($q) use ($competencia) {
            $q->where('red_conocimientos.id', $competencia->programaFormacion->redConocimiento->id);
        })->get();

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
            DB::transaction(function () use ($validatedData) {
                $competencia = Competencia::findOrFail($validatedData['competencia_id']);
                
                // Verificar horas disponibles
                if ($competencia->horasDisponiblesParaAsignar() < $validatedData['horas_asignadas']) {
                    throw new \Exception('No hay suficientes horas disponibles para asignar.');
                }

                $competencia->instructores()->attach($validatedData['instructor_id'], [
                    'fecha_inicio' => $validatedData['fecha_inicio'],
                    'fecha_fin' => $validatedData['fecha_fin'],
                    'horas_asignadas' => $validatedData['horas_asignadas'],
                    'horario' => json_encode($validatedData['horario']),
                    'estado' => 'activo'
                ]);
            });

            return redirect()->route('competencias.show', $validatedData['competencia_id'])
                           ->with('success', 'Instructor asignado correctamente');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }
}