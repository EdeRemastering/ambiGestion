<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('personas', function (Blueprint $table) {
        $table->id(); // Usa id() en lugar de increments() para consistencia con Laravel moderno
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('documento');
        $table->string('pnombre');
        $table->string('snombre');
        $table->string('papellido');
        $table->string('sapellido');
        $table->string('telefono');
        $table->string('correo');
        $table->string('direccion');
        
        // Añade las columnas para las claves foráneas
        $table->unsignedBigInteger('rol_id');
        $table->unsignedBigInteger('tipo_sangre_id');
        $table->unsignedBigInteger('tipo_contrato_id');
        $table->unsignedBigInteger('user_id')->nullable();
        // Define las relaciones
        $table->foreign('rol_id')->references('id')->on('roles');
        $table->foreign('tipo_sangre_id')->references('id')->on('grupo_sanguineos');
        $table->foreign('tipo_contrato_id')->references('id')->on('contratos');
        
        $table->timestamps();});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
