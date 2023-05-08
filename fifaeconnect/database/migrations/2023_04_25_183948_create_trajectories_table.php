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
        Schema::create('trajectories', function (Blueprint $table) {
            $table->id('id_trajectoria');
            $table->unsignedBigInteger('id_jugador');
            $table->foreign('id_jugador')
                    ->references('id_jugador')->on('jugadors')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->unsignedBigInteger('club')->nullable();
            $table->foreign('club')
                    ->references('id_club')->on('clubs')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->year('any_inici');
            $table->year('any_final');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trajectories');
    }
};
