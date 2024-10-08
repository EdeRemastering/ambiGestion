<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultadoAprendizaje extends Model
{
    use HasFactory;

    protected $fillable = ['codigo', 'descripcion', 'intensidad_horaria', 'competencia_id'];

    public function competencia()
    {
        return $this->belongsTo(Competencia::class);
    }
}