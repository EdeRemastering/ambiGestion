<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'version',  'red_conocimiento', 'duracion_meses', 'requisitos_ingreso', 'requisitos_formacion'];
}
//aqui van los campos de mi tabla
