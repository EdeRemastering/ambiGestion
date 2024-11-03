<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AmbienteProgramacion extends Model
{
    protected $table = 'ambiente_programacions';

    protected $fillable = [
        'ambiente_id',
        'ficha_id',
        'jornada_id',
        'competencia_id',
        'resultado_aprendizaje_id', // Agregado este campo
        'persona_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'horas_asignadas',
        'horas_restantes',
        'estado'
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora_inicio' => 'datetime',
        'hora_fin' => 'datetime',
        'horas_asignadas' => 'integer',
        'horas_restantes' => 'integer'
    ];

    protected $attributes = [
        'estado' => 'programado'
    ];

    // Relationships
    public function ambiente(): BelongsTo
    {
        return $this->belongsTo(Ambiente::class);
    }

    public function ficha(): BelongsTo
    {
        return $this->belongsTo(Ficha::class);
    }

    public function jornada(): BelongsTo
    {
        return $this->belongsTo(Jornada::class);
    }

    public function competencia(): BelongsTo
    {
        return $this->belongsTo(Competencia::class);
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Personas::class, 'persona_id');
    }

    public function resultadoAprendizaje(): BelongsTo
    {
        return $this->belongsTo(ResultadoAprendizaje::class);
    }

    // Accessors & Mutators
    public function getHoraInicioFormateadaAttribute()
    {
        return $this->hora_inicio ? Carbon::parse($this->hora_inicio)->format('H:i') : '';
    }

    public function getHoraFinFormateadaAttribute()
    {
        return $this->hora_fin ? Carbon::parse($this->hora_fin)->format('H:i') : '';
    }

    public function getFechaFormateadaAttribute()
    {
        return $this->fecha ? $this->fecha->format('d/m/Y') : '';
    }
}