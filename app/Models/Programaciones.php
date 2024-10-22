<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programaciones extends Model
{
    use HasFactory;
    protected $fillable = ['ficha', 'ambiente',  'instructor_asignante', 'hora_inicio', 'hora_fin', 'fecha_inicio', 'fecha_fin', 'estado'];
}
//aqui van los campos de mi tabla
