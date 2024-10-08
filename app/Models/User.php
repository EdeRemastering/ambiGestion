<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',  // Añadimos role_id a los campos llenables
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function persona()
    {
        return $this->hasOne(Personas::class);
    }

    public function role()
    {
        return $this->belongsTo(Roles::class);
    }

    public function hasRole($role)
    {
        return $this->role->name === $role;
    }

    public function esInstructor()
    {
        return $this->hasRole('instructor');
    }

    public function esAprendiz()
    {
        return $this->hasRole('aprendiz');
    }

    public function esAdministrador()
    {
        return $this->hasRole('admin');
    }
}