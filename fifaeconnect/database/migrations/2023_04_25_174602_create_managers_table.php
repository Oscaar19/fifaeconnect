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
        Schema::create('managers', function (Blueprint $table) {
            $table->id('id_manager');
            $table->string('foto');
            $table->json('xarxes_socials');
            $table->unsignedBigInteger('club_actual');
            $table->boolean('fa');
            $table->foreign('club_actual')->references('id_club')->on('clubs');
            $table->foreign('id_manager')->references('id_usuari')->on('usuaris');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('managers');
    }
};
