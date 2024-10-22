<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoRecurso extends Model
{
    use HasFactory;
    protected $fillable = ['nombre'];
}
//aqui van los campos de mi tabla
