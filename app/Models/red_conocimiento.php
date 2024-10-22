<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class red_conocimiento extends Model
{
    use HasFactory;

    protected $table = 'red_de_formacion';

    protected $primary_key = 'id_area_formacion';

    protected $fillable = ['nombre'];
}
