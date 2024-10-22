<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultadoAprendizaje extends Model
{
    use HasFactory;
    protected $fillable = ['codigo', 'descripcion', 'duracion_horas', 'intensidad_horaria', 'competencia_id'];
}
//aqui van los campos de mi tabla
