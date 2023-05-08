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
        Schema::create('experiencies', function (Blueprint $table) {
            $table->id('id_experiencia');
            $table->string('descripcio');
            $table->unsignedBigInteger('id_entrenador');
            $table->foreign('id_entrenador')
                    ->references('id_entrenador')->on('entrenadors')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiencies');
    }
};
