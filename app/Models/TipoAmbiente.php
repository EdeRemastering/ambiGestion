<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAmbiente extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    public function ambientes()
    {
        return $this->hasMany(Ambiente::class);
    }
}