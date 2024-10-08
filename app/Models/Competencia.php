<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competencia extends Model
{
    use HasFactory;

    protected $fillable = ['codigo', 'descripcion', 'programa_formacion_id'];

    public function programaFormacion()
    {
        return $this->belongsTo(ProgramaFormacion::class, 'programa_formacion_id');
    }

    public function resultadosAprendizaje()
    {
        return $this->hasMany(ResultadoAprendizaje::class);
    }

    public function intensidadHorariaTotal()
    {
        return $this->resultadosAprendizaje()->sum('intensidad_horaria');
    }
}