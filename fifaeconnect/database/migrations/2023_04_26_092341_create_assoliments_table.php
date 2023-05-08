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
        Schema::create('assoliments', function (Blueprint $table) {
            $table->id('id_assoliment');
            $table->string('assoliment');
            $table->year('any');
            $table->unsignedBigInteger('jugador');
            $table->foreign('jugador')
                    ->references('id_jugador')->on('jugadors')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assoliments');
    }
};
