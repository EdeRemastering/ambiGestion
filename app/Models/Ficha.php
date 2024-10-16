<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ficha extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla si es necesario
    protected $table = 'fichas';

    // Especifica la clave primaria de la tabla
    protected $primaryKey = 'id_ficha';

    // Si tu clave primaria no es de tipo incremental, añade esta línea
    public $incrementing = false;

    // Define el tipo de la clave primaria si es algo distinto de un entero
    protected $keyType = 'string';

    // Especifica los campos que pueden ser asignados masivamente
    protected $fillable = [
        'id_ficha',
        'id_programa_formacion',
        'nombre',
        'hora_entrada',
        'hora_salida',
        'jornada',
        'fecha_inicio',
        'fecha_fin',
        'fecha_creacion'
    ];
}