<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramaFormacion extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = 'programa__formacions';

    protected $fillable = [
        'nombre',
        'codigo',
        'version',
        'descripcion',
        'duracion_meses',
        'red_conocimiento_id'  
    ];

    public function redConocimiento()
    {
        return $this->belongsTo(RedConocimiento::class, 'red_conocimiento_id');
    }

    public function competencias()
    {
        return $this->hasMany(Competencia::class);
    }

}