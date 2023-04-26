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
        Schema::create('usuaris', function (Blueprint $table) {
            $table->id('id_usuari');
            $table->string('nom');
            $table->string('cognom');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken()->nullable();
            $table->string('foto');
            $table->json('xarxes_socials');
            $table->boolean('fa');
            $table->unsignedBigInteger('club_actual');
            $table->foreign('club_actual')
                    ->references('id_club')->on('clubs')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuaris');
    }
};
