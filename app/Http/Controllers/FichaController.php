<?php

namespace App\Http\Controllers;

use App\Models\Ficha;
use App\Models\ProgramaFormacion;
use App\Models\RedConocimiento;
use App\Models\Jornada;
use App\Models\Personas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FichaController extends Controller 
{
    public function index() 
    {
        $fichas = Ficha::with(['programaFormacion', 'redConocimiento', 'instructor'])
            ->get()
            ->map(function ($ficha) {
                $ficha->fecha_inicio = Carbon::parse($ficha->fecha_inicio);
                $ficha->fecha_fin = Carbon::parse($ficha->fecha_fin);
                $ficha->fecha_fin_lectiva = Carbon::parse($ficha->fecha_fin_lectiva);
                $ficha->fecha_inicio_practica = Carbon::parse($ficha->fecha_inicio_practica);
                return $ficha;
            });
    
        return view('fichas.index', compact('fichas'));
    }

    public function create() 
{
    $jornadas = Jornada::select('id', 'nombre', 'hora_inicio', 'hora_fin')->get();
    $programasFormacion = ProgramaFormacion::with('redConocimiento')->get();
    
    $instructores = Personas::whereHas('user.role', function($query) {
        $query->where('name', 'instructor');
    })
    ->select('personas.id', 'personas.pnombre', 'personas.snombre', 
             'personas.papellido', 'personas.sapellido', 'personas.documento')
    ->with(['user.role', 'redesConocimiento'])
    ->get();

    return view('fichas.create', compact('jornadas', 'programasFormacion', 'instructores'));
}
    
    public function getInstructoresPorRed($redId)
    {
        $instructores = Personas::whereHas('user.role', function($query) {
            $query->where('name', 'instructor');
        })
        ->whereHas('redesConocimiento', function($query) use ($redId) {
            $query->where('red_conocimientos.id', $redId);
        })
        ->select('personas.id', 'personas.pnombre', 'personas.snombre', 
                 'personas.papellido', 'personas.sapellido', 'personas.documento')
        ->with(['user.role', 'redesConocimiento'])
        ->get()
        ->map(function($instructor) {
            return [
                'id' => $instructor->id,
                'texto' => trim(sprintf('%s %s %s %s - %s',
                    $instructor->pnombre,
                    $instructor->snombre ?: '',
                    $instructor->papellido,
                    $instructor->sapellido ?: '',
                    $instructor->documento
                ))
            ];
        });
    
        return response()->json($instructores);
    }

public function store(Request $request)
{
    $validatedData = $request->validate([
        'codigo_ficha' => 'required|unique:fichas',
        'instructor_lider' => 'required|exists:personas,id',
        'numero_aprendices' => 'required|integer|min:1',
        'fecha_inicio' => 'required|date',
        'programa_formacion_id' => 'required|exists:programa__formacions,id',
        'red_conocimiento_id' => 'required|exists:red_conocimientos,id',
        'jornada_id' => 'required|exists:jornadas,id',
        'hora_entrada' => 'required',
        'hora_salida' => 'required',
    ]);

    try {
        return DB::transaction(function() use ($validatedData) {
            // Verificar que el instructor pertenece a la red de conocimiento
            $instructor = Personas::findOrFail($validatedData['instructor_lider']);
            
            if (!$instructor->redesConocimiento()
                           ->where('red_conocimiento_id', $validatedData['red_conocimiento_id'])
                           ->exists()) {
                throw new \Exception('El instructor no pertenece a la red de conocimiento del programa.');
            }

            $ficha = Ficha::create($validatedData);
            $ficha->calcularFechas();
            $ficha->save();

            return redirect()
                ->route('fichas.index')
                ->with('success', 'Ficha creada exitosamente.');
        });

    } catch (\Exception $e) {
        return back()
            ->withErrors(['error' => $e->getMessage()])
            ->withInput();
    }
}

public function show(Ficha $ficha)
{
    $ficha->load(['programaFormacion', 'redConocimiento', 'instructor', 'jornada']);
    
    // Convertir fechas a Carbon
    $ficha->fecha_inicio = Carbon::parse($ficha->fecha_inicio);
    $ficha->fecha_fin = Carbon::parse($ficha->fecha_fin);
    $ficha->fecha_fin_lectiva = Carbon::parse($ficha->fecha_fin_lectiva);
    $ficha->fecha_inicio_practica = Carbon::parse($ficha->fecha_inicio_practica);
    
    return view('fichas.show', compact('ficha'));
}

public function edit(Ficha $ficha)
{
    $jornadas = Jornada::all();
    $programasFormacion = ProgramaFormacion::with('redConocimiento')->get();
    $redesConocimiento = RedConocimiento::all();
    
    // Convertir fechas a Carbon
    $ficha->fecha_inicio = Carbon::parse($ficha->fecha_inicio);
    $ficha->fecha_fin = Carbon::parse($ficha->fecha_fin);
    $ficha->fecha_fin_lectiva = Carbon::parse($ficha->fecha_fin_lectiva);
    $ficha->fecha_inicio_practica = Carbon::parse($ficha->fecha_inicio_practica);
    
    return view('fichas.edit', compact('ficha', 'jornadas', 'programasFormacion', 'redesConocimiento'));
}

    public function update(Request $request, Ficha $ficha)
    {
        $validatedData = $request->validate([
            'codigo_ficha' => 'required|unique:fichas,codigo_ficha,' . $ficha->id,
            'instructor_lider' => 'required|exists:personas,id',
            'numero_aprendices' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date',
            'programa_formacion_id' => 'required|exists:programa__formacions,id',
            'red_conocimiento_id' => 'required|exists:red_conocimientos,id',
            'jornada_id' => 'required|exists:jornadas,id',
            'hora_entrada' => 'required',
            'hora_salida' => 'required',
        ]);

        $ficha->fill($validatedData);
        $ficha->calcularFechas();
        $ficha->save();

        return redirect()->route('fichas.index')->with('success', 'Ficha actualizada exitosamente.');
    }

    public function destroy(Ficha $ficha)
    {
        $ficha->delete();
        return redirect()->route('fichas.index')->with('success', 'Ficha eliminada exitosamente.');
    }

    
    public function imprimirAprendices(Ficha $ficha)
{
    $ficha->load(['programaFormacion', 'instructor', 'jornada']);
    $aprendices = $ficha->aprendices()
        ->orderBy('papellido')
        ->orderBy('pnombre')
        ->get();
    
    $pdf = PDF::loadView('fichas.imprimir-aprendices', 
        compact('ficha', 'aprendices'))
        ->setPaper('a4', 'landscape');
    
    return $pdf->stream("Listado_Aprendices_Ficha_{$ficha->codigo_ficha}.pdf");
}
}