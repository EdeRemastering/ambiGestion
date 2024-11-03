<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Novedad extends Model
{
    use HasFactory;

    
    protected $table = 'novedad';

    public $timestamps = false;

    protected $fillable = ['id', 'nombre', 'id_recurso', 'descripcion', 'estado', 'fecha_solucion', 'descripcion_solucion'];
}
