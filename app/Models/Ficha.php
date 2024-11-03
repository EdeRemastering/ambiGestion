<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Ficha extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_ficha',
        'instructor_lider',
        'numero_aprendices',
        'fecha_inicio',
        'fecha_fin',
        'fecha_fin_lectiva',
        'fecha_inicio_practica',
        'hora_entrada',
        'hora_salida',
        'programa_formacion_id',
        'red_conocimiento_id',
        'jornada_id'
    ];

    protected $dates = [
        'fecha_inicio',
        'fecha_fin',
        'fecha_fin_lectiva',
        'fecha_inicio_practica',
        'created_at',
        'updated_at'
    ];

    // Relaciones
    public function programaFormacion()
    {
        return $this->belongsTo(ProgramaFormacion::class, 'programa_formacion_id');
    }

    public function redConocimiento()
    {
        return $this->belongsTo(RedConocimiento::class, 'red_conocimiento_id');
    }

    public function jornada()
    {
        return $this->belongsTo(Jornada::class, 'jornada_id');
    }

    public function instructor()
    {
        return $this->belongsTo(Personas::class, 'instructor_lider');
    }

    public function aprendices()
{
    return $this->hasMany(Personas::class, 'codigo_ficha', 'codigo_ficha')
        ->whereHas('user', function($query) {
            $query->whereHas('role', function($q) {
                $q->where('name', 'aprendiz');
            });
        });
}
    // Métodos
    public function calcularFechas()
    {
        $duracionMeses = $this->programaFormacion->duracion_meses;
        
        $this->fecha_fin = Carbon::parse($this->fecha_inicio)->addMonths($duracionMeses);
        $this->fecha_fin_lectiva = Carbon::parse($this->fecha_fin)->subMonths(6);
        $this->fecha_inicio_practica = Carbon::parse($this->fecha_fin_lectiva)->addDays(1);
    }

    // Mutadores
    public function setCodigoFichaAttribute($value)
    {
        $this->attributes['codigo_ficha'] = strtoupper($value);
    }

    // Accesores
    public function getFechaInicioFormateadaAttribute()
    {
        return $this->fecha_inicio ? $this->fecha_inicio->format('d/m/Y') : '';
    }

    public function getFechaFinFormateadaAttribute()
    {
        return $this->fecha_fin ? $this->fecha_fin->format('d/m/Y') : '';
    }

    public function getFechaFinLectivaFormateadaAttribute()
    {
        return $this->fecha_fin_lectiva ? $this->fecha_fin_lectiva->format('d/m/Y') : '';
    }

    public function getFechaInicioPracticaFormateadaAttribute()
    {
        return $this->fecha_inicio_practica ? $this->fecha_inicio_practica->format('d/m/Y') : '';
    }

    public function getEstadoActualAttribute()
    {
        $hoy = Carbon::now();
        
        if ($hoy < $this->fecha_inicio) {
            return 'Por Iniciar';
        } elseif ($hoy <= $this->fecha_fin_lectiva) {
            return 'Etapa Lectiva';
        } elseif ($hoy <= $this->fecha_fin) {
            return 'Etapa Práctica';
        } else {
            return 'Finalizada';
        }
    }

    public function getEstaActivaAttribute()
    {
        $hoy = Carbon::now();
        return $hoy >= $this->fecha_inicio && $hoy <= $this->fecha_fin;
    }

    // Scopes
    public function scopeActivas($query)
    {
        $hoy = Carbon::now();
        return $query->where('fecha_inicio', '<=', $hoy)
                    ->where('fecha_fin', '>=', $hoy);
    }

    public function scopePorIniciar($query)
    {
        return $query->where('fecha_inicio', '>', Carbon::now());
    }

    public function scopeFinalizadas($query)
    {
        return $query->where('fecha_fin', '<', Carbon::now());
    }

    public function scopeEtapaLectiva($query)
    {
        $hoy = Carbon::now();
        return $query->where('fecha_inicio', '<=', $hoy)
                    ->where('fecha_fin_lectiva', '>=', $hoy);
    }

    public function scopeEtapaPractica($query)
    {
        $hoy = Carbon::now();
        return $query->where('fecha_fin_lectiva', '<', $hoy)
                    ->where('fecha_fin', '>=', $hoy);
    }

    // Boot method para eventos del modelo
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ficha) {
            if (!$ficha->fecha_fin) {
                $ficha->calcularFechas();
            }
        });

        static::updating(function ($ficha) {
            if ($ficha->isDirty('fecha_inicio') || $ficha->isDirty('programa_formacion_id')) {
                $ficha->calcularFechas();
            }
        });
    }
}