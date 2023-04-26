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
        Schema::create('jugadors', function (Blueprint $table) {
            $table->id('id_jugador');            
            $table->foreign('id_jugador')
                    ->references('id_usuari')->on('usuaris')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->unsignedBigInteger('id_moderador');
            $table->foreign('id_moderador')
                    ->references('id_moderador')->on('moderadors')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jugadors');
    }
};
