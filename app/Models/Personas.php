<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personas extends Model
{
    use HasFactory;

    protected $fillable = [
        'documento',
        'pnombre',
        'snombre',
        'papellido',
        'sapellido',
        'telefono',
        'correo',
        'direccion',
        'tipo_sangre_id',
        'user_id',
        'tipo_contrato_id',
    ];

    protected $casts = [
        'tipo_contrato_id' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function grupoSanguineo()
    {
        return $this->belongsTo(Grupo_sanguineo::class, 'tipo_sangre_id');
    }

    public function tipoContrato()
    {
        return $this->belongsTo(Contratos::class, 'tipo_contrato_id');
    }

    public function rol()
    {
        return $this->user ? $this->user->role() : null;
    }

    public function esInstructor()
    {
        return $this->user && $this->user->role && $this->user->role->name === 'instructor';
    }

    public function esAprendiz()
    {
        return $this->user && $this->user->role && $this->user->role->name === 'aprendiz';
    }

    public function esAdministrador()
    {
        return $this->user && $this->user->role && $this->user->role->name === 'admin';
    }
}