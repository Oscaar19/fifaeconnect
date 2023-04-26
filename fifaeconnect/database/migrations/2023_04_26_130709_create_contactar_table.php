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
        Schema::create('contactar', function (Blueprint $table) {
            $table->unsignedBigInteger('id_jugador');
            $table->foreign('id_jugador')
                    ->references('id_jugador')->on('jugadors')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->unsignedBigInteger('id_entrenador');
            $table->foreign('id_entrenador')
                    ->references('id_entrenador')->on('entrenadors')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->unsignedBigInteger('id_manager');
            $table->foreign('id_manager')
                    ->references('id_manager')->on('managers')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            
            $table->unique(['id_jugador', 'id_entrenador','id_manager']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactar');
    }
};
