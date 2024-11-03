<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambiente extends Model
{
    use HasFactory;

    protected $table = 'ambientes';

    protected $fillable = [
        'numero', 
        'alias', 
        'capacidad', 
        'descripcion', 
        'tipo_id',  // Cambiado de 'tipo'
        'estado_id', // Cambiado de 'estado'
        'red_conocimiento_id' // Cambiado de 'red_de_conocimiento'
    ];

    public function estadoAmbiente()
    {
        return $this->belongsTo(EstadoAmbiente::class, 'estado_id');
    }

    public function tipoAmbiente()
    {
        return $this->belongsTo(TipoAmbiente::class, 'tipo_id'); // Cambiado de 'tipo'
    }

    public function redConocimiento()
    {
        return $this->belongsTo(RedConocimiento::class, 'red_conocimiento_id'); // Cambiado
    }

    // Método para obtener ambientes con relaciones
    public static function getAmbientesConRelaciones()
    {
        return self::with(['estadoAmbiente', 'tipoAmbiente', 'redConocimiento'])->get();
    }

    // Método para obtener estadísticas
    public static function getEstadisticas()
    {
        $ambientesPorEstado = self::groupBy('estado_id') // Cambiado de 'estado'
            ->selectRaw('estado_id, count(*) as total')
            ->get();

        $ambientesTotal = self::count();

        return [
            'ambientesPorEstado' => $ambientesPorEstado,
            'ambientesTotal' => $ambientesTotal
        ];
    }
}