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
        Schema::create('assoliment-jugador', function (Blueprint $table) {
            $table->unsignedBigInteger('id_jugador');
            $table->foreign('id_jugador')
                    ->references('id_jugador')->on('jugadors')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->unsignedBigInteger('id_assoliment');
            $table->foreign('id_assoliment')
                    ->references('id_assoliment')->on('assoliments')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->unique(['id_jugador', 'id_assoliment']);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assoliment-jugador');
    }
};
