<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeTipoContratoIdNullableInPersonasTable extends Migration
{
    public function up()
    {
        Schema::table('personas', function (Blueprint $table) {
            $table->unsignedBigInteger('tipo_contrato_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('personas', function (Blueprint $table) {
            $table->unsignedBigInteger('tipo_contrato_id')->change();
        });
    }
}