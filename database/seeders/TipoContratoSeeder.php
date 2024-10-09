<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoContratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    \App\Models\TipoContrato::create(['nombre' => 'Tipo 1']);
    \App\Models\TipoContrato::create(['nombre' => 'Tipo 2']);
    // Agrega más tipos según sea necesario
}
}
