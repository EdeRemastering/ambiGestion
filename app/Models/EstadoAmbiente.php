<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoAmbiente extends Model
{
    protected $table = 'estado_ambiente';
    protected $fillable = ['nombre'];

    // Si no usas timestamps (created_at y updated_at)
    public $timestamps = false;

    // Relación con ambientes
    public function ambientes()
    {
        return $this->hasMany(Ambiente::class, 'estado_id');
    }
}