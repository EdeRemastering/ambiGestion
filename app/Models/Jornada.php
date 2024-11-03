<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jornada extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'hora_inicio', 'hora_fin'];

    public function fichas()
    {
        return $this->hasMany(Ficha::class);
    }
}