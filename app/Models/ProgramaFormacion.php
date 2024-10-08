<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramaFormacion extends Model
{
    use HasFactory;

    protected $table = 'programa__formacions';

    protected $fillable = [
        'nombre',
        'codigo',
        'version',
        'descripcion',
        'duracion_meses'
    ];

    public function competencias()
    {
        return $this->hasMany(Competencia::class, 'programa_formacion_id');
    }
}