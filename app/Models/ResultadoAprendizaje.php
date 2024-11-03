<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\AmbienteProgramacion;
use App\Models\Competencia;

class ResultadoAprendizaje extends Model
{
    protected $table = 'resultado_aprendizajes';

    protected $fillable = [
        'competencia_id',
        'intensidad_horaria',
        'is_manually_edited'
    ];

    public function competencia(): BelongsTo
    {
        return $this->belongsTo(Competencia::class);
    }

    public function programaciones(): HasMany
    {
        return $this->hasMany(AmbienteProgramacion::class, 'resultado_aprendizaje_id', 'id');
    }
}