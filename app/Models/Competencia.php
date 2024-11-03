<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'descripcion',
        'programa_formacion_id',
        'duracion_horas'
    ];
    protected $attributes = [
        'duracion_horas' => 0
    ];

    public function programaFormacion()
    {
        return $this->belongsTo(ProgramaFormacion::class);
    }

    public function redConocimiento()
    {
        return $this->hasOneThrough(
            RedConocimiento::class,
            ProgramaFormacion::class,
            'id', // Llave foránea en competencias (programa_formacion_id)
            'id', // Llave primaria en red_conocimientos
            'programa_formacion_id', // Llave local en competencias
            'red_conocimiento_id' // Llave foránea en programa_formacions
        );
    }

    // Relación con instructores
    public function instructores()
    {
        return $this->belongsToMany(Personas::class, 'competencia_instructor', 
            'competencia_id', 'instructor_id')
            ->withPivot(['fecha_inicio', 'fecha_fin', 'horas_asignadas', 'estado', 'horario'])
            ->withTimestamps();
    }

    // Método para obtener instructores disponibles de la red correspondiente
    public function getInstructoresDisponibles()
    {
        return Personas::whereHas('user.role', function($q) {
                $q->where('name', 'instructor');
            })
            ->whereHas('redesConocimiento', function($q) {
                $q->where('red_conocimientos.id', $this->programaFormacion->red_conocimiento_id);
            })
            ->get();
    }

    public function horasDisponibles()
{
    $horasAsignadas = $this->resultadosAprendizaje()->sum('intensidad_horaria');
    $resultadosCount = $this->resultadosAprendizaje()->count();
    if ($resultadosCount == 0) {
        return $this->duracion_horas;
    }
    return floor($this->duracion_horas / ($resultadosCount + 1));
}
public function horasDisponiblesParaAsignar(): float
{
    $horasAsignadas = $this->instructores()
        ->wherePivot('estado', 'activo')
        ->sum('horas_asignadas') ?? 0;
    
    return (float)$this->attributes['duracion_horas'] - $horasAsignadas;
}
   
public function redistribuirHoras()
{
    $resultados = $this->resultadosAprendizaje;
    $cantidadResultados = $resultados->count();
    
    if ($cantidadResultados > 0) {
        $horasPorResultado = floor($this->duracion_horas / $cantidadResultados);
        $horasRestantes = $this->duracion_horas % $cantidadResultados;

        foreach ($resultados as $index => $resultado) {
            $horas = $horasPorResultado;
            if ($index < $horasRestantes) {
                $horas++;
            }
            $resultado->intensidad_horaria = $horas;
            $resultado->save();
        }
    }
}
public function resultadosAprendizaje()
{
    return $this->hasMany(ResultadoAprendizaje::class);
}

public function distribuirHorasAutomaticamente()
    {
        $resultados = $this->resultadosAprendizaje;
        $totalResultados = $resultados->count();

        if ($totalResultados > 0) {
            $horasPorResultado = floor($this->duracion_horas / $totalResultados);
            $horasRestantes = $this->duracion_horas % $totalResultados;

            $resultados->each(function ($resultado, $index) use ($horasPorResultado, $horasRestantes) {
                $horas = $horasPorResultado;
                if ($index < $horasRestantes) {
                    $horas++;
                }
                $resultado->update(['intensidad_horaria' => $horas]);
            });

            return true;
        }

        return false;
    }
}