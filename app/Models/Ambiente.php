<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambiente extends Model
{
    use HasFactory;

    protected $fillable = ['numero', 'alias', 'capacidad',  'descripcion', 'tipo', 'estado', 'red_de_conocimiento'];
}
