<?php

namespace App\Http\Controllers;

use App\Models\ResultadoAprendizaje;
use App\Models\Competencia;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ResultadoAprendizajeController extends Controller
{
    public function index()
    {
        $resultadosAprendizaje = ResultadoAprendizaje::with('competencia')->get();
        return view('resultados_aprendizaje.index', compact('resultadosAprendizaje'));
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
            'competencia_id' => 'required|exists:competencias,id',
        ]);
    
        $competencia = Competencia::findOrFail($validatedData['competencia_id']);
        $horasTotales = $competencia->duracion_horas;
    
        DB::transaction(function () use ($validatedData, $competencia, $horasTotales) {
            $resultadosExistentes = $competencia->resultadosAprendizaje;
            $horasAsignadasEditadas = $resultadosExistentes->where('is_manually_edited', true)->sum('intensidad_horaria');
            $horasDisponibles = $horasTotales - $horasAsignadasEditadas;
    
            // Crear el nuevo resultado con 1 hora inicialmente
            $nuevoResultado = ResultadoAprendizaje::create([
                'codigo' => $validatedData['codigo'],
                'descripcion' => $validatedData['descripcion'],
                'competencia_id' => $validatedData['competencia_id'],
                'intensidad_horaria' => 1,
                'is_manually_edited' => false,
            ]);
    
            // Redistribuir las horas entre los resultados no editados manualmente
            $resultadosNoEditados = $resultadosExistentes->where('is_manually_edited', false)->push($nuevoResultado);
            $cantidadResultadosNoEditados = $resultadosNoEditados->count();
    
            if ($cantidadResultadosNoEditados > 0) {
                $horasPorResultado = floor($horasDisponibles / $cantidadResultadosNoEditados);
                $horasExtra = $horasDisponibles % $cantidadResultadosNoEditados;
    
                foreach ($resultadosNoEditados as $resultado) {
                    $nuevasHoras = $horasPorResultado + ($horasExtra > 0 ? 1 : 0);
                    $resultado->update([
                        'intensidad_horaria' => $nuevasHoras,
                        'is_manually_edited' => false
                    ]);
                    $horasExtra--;
                }
            }
        });
    
        return redirect()->route('resultados_aprendizaje.index')
            ->with('success', 'Resultado de aprendizaje creado exitosamente y horas redistribuidas.');
    }

public function show(ResultadoAprendizaje $resultadoAprendizaje)
{
    return view('resultados_aprendizaje.show', ['resultado' => $resultadoAprendizaje]);
}

    public function edit(ResultadoAprendizaje $resultadoAprendizaje)
{
    $competencias = Competencia::all();
    return view('resultados_aprendizaje.edit', compact('resultadoAprendizaje', 'competencias'));
}

public function update(Request $request, ResultadoAprendizaje $resultadoAprendizaje)
{
    $validatedData = $request->validate([
        'codigo' => 'required|unique:resultado_aprendizajes,codigo,' . $resultadoAprendizaje->id,
        'descripcion' => 'required',
        'intensidad_horaria' => 'required|integer|min:1',
        'competencia_id' => 'required|exists:competencias,id',
    ]);

    DB::transaction(function () use ($validatedData, $resultadoAprendizaje) {
        $competencia = Competencia::findOrFail($validatedData['competencia_id']);
        $horasTotales = $competencia->duracion_horas;
        
        $todosLosResultados = $competencia->resultadosAprendizaje()->get();
        $horasAsignadasOtros = $todosLosResultados->where('id', '!=', $resultadoAprendizaje->id)
                                                  ->where('is_manually_edited', true)
                                                  ->sum('intensidad_horaria');
        
        $horasDisponibles = $horasTotales - $horasAsignadasOtros;
        
        if ($validatedData['intensidad_horaria'] > $horasDisponibles) {
            throw new \Exception('Las horas asignadas exceden las horas disponibles.');
        }

        $resultadoAprendizaje->update($validatedData + ['is_manually_edited' => true]);

        // Redistribuir horas restantes entre resultados no editados manualmente
        $horasRestantes = $horasDisponibles - $validatedData['intensidad_horaria'];
        $resultadosNoEditados = $todosLosResultados->where('id', '!=', $resultadoAprendizaje->id)
                                                   ->where('is_manually_edited', false);
        
        if ($resultadosNoEditados->count() > 0) {
            $horasPorResultado = floor($horasRestantes / $resultadosNoEditados->count());
            $horasExtra = $horasRestantes % $resultadosNoEditados->count();

            foreach ($resultadosNoEditados as $resultado) {
                $nuevasHoras = $horasPorResultado + ($horasExtra > 0 ? 1 : 0);
                $resultado->update([
                    'intensidad_horaria' => $nuevasHoras,
                    'is_manually_edited' => false
                ]);
                $horasExtra--;
            }
        }
    });

    return redirect()->route('resultados_aprendizaje.index')
        ->with('success', 'Resultado de aprendizaje actualizado exitosamente y horas redistribuidas.');
}

public function destroy(ResultadoAprendizaje $resultadoAprendizaje)
{
    DB::transaction(function () use ($resultadoAprendizaje) {
        $competencia = $resultadoAprendizaje->competencia;
        $horasTotales = $competencia->duracion_horas;

        // Eliminar el resultado de aprendizaje
        $resultadoAprendizaje->delete();

        // Obtener los resultados de aprendizaje restantes no editados manualmente
        $resultadosNoEditados = $competencia->resultadosAprendizaje()->where('is_manually_edited', false)->get();
        $horasAsignadasEditadas = $competencia->resultadosAprendizaje()->where('is_manually_edited', true)->sum('intensidad_horaria');
        $horasDisponibles = $horasTotales - $horasAsignadasEditadas;

        $cantidadResultadosNoEditados = $resultadosNoEditados->count();

        if ($cantidadResultadosNoEditados > 0) {
            $horasPorResultado = floor($horasDisponibles / $cantidadResultadosNoEditados);
            $horasExtra = $horasDisponibles % $cantidadResultadosNoEditados;

            foreach ($resultadosNoEditados as $resultado) {
                $nuevasHoras = $horasPorResultado + ($horasExtra > 0 ? 1 : 0);
                $resultado->update([
                    'intensidad_horaria' => $nuevasHoras,
                    'is_manually_edited' => false
                ]);
                $horasExtra--;
            }
        }
    });

    return redirect()->route('resultados_aprendizaje.index')
        ->with('success', 'Resultado de aprendizaje eliminado exitosamente y horas redistribuidas.');
}
    public function updateHoras(Request $request, Competencia $competencia)
    {
        $request->validate([
            'horas' => 'required|array',
            'horas.*' => 'required|integer|min:0'
        ]);
    
        $totalHoras = array_sum($request->horas);
    
        if ($totalHoras > $competencia->duracion_horas) {
            return redirect()->back()->with('error', 'El total de horas excede la duración de la competencia.');
        }
    
        foreach ($request->horas as $id => $horas) {
            $resultado = $competencia->resultadosAprendizaje()->findOrFail($id);
            $resultado->update(['duracion_horas' => $horas]);
        }
    
        return redirect()->route('resultados_aprendizaje.index')
        ->with('success', 'Resultado de aprendizaje actualizado exitosamente.');
    }
}