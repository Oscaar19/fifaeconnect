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
            $table->string('foto');
            $table->json('xarxes_socials');
            $table->boolean('fa');
            $table->unsignedBigInteger('club_actual');
            $table->foreign('club_actual')->references('id_club')->on('clubs');
            $table->foreign('id_jugador')->references('id_usuari')->on('usuaris');
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
