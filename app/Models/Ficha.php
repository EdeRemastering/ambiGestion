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

    // Especifica los campos que pueden ser asignados masivamente
    protected $fillable = [
        'id_ficha',
        'id_programa_formacion',
        'nombre',
        'jornada',
        'fecha_inicio',
        'fecha_fin',
    ];
}