<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramaFormacionsTable extends Migration
{
    public function up()
    {
        Schema::create('programa__formacions', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('codigo')->unique();
            $table->string('version');
            $table->text('descripcion');
            $table->integer('duracion_meses');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('programa__formacions');
    }
}