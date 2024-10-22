<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambiente extends Model
{
    use HasFactory;

    protected $fillable = ['numero', 'alias', 'capacidad',  'descripcion', 'tipo', 'estado', 'red_de_conocimiento'];

    public function tipoAmbinete() {
        return $this->belongsTo(TipoAmbiente::class, 'tipo');
    }

    public function redDeConocimiento() {
        return $this->belongsTo(red_conocimiento::class, 'red_de_conocimiento');
    }
}
