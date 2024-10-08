<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->string('name')->unique();
        });
    }
    
    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }
};
