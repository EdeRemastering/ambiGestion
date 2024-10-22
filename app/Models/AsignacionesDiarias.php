<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionesDiarias extends Model
{
    use HasFactory;
    protected $fillable = ['programacion', 'dia',  'instructor_asignado', 'fecha'];
}
//aqui van los campos de mi tabla
