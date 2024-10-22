<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competencia extends Model
{
    use HasFactory;
    protected $fillable = ['codigo', 'descripcion',  'programa_formacion_id'];
}
//aqui van los campos de mi tabla
