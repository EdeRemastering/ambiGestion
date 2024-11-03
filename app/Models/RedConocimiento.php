<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedConocimiento extends Model
{
    use HasFactory;

    protected $table = 'red_conocimientos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'descripcion',
        'codigo',
    ];

    public function fichas()
    {
        return $this->hasMany(Ficha::class);
    }

    public function coordinadores()
    {
        return $this->hasMany(User::class)->where('role', 'coordinador');
    }

    public function instructores()
    {
        return $this->hasMany(User::class)->where('role', 'instructor');
        return $this->belongsToMany(Personas::class, 'instructor_red_conocimiento', 'red_conocimiento_id', 'persona_id');
   
    }

    public function programasFormacion()
    {
        return $this->hasMany(ProgramaFormacion::class);
    }

    // Nueva relación para ambientes
    public function ambientes()
    {
        return $this->hasMany(Ambiente::class, 'red_de_conocimiento', 'id');
    }

    
}