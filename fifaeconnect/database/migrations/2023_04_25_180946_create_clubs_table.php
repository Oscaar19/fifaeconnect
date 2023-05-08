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
        Schema::create('clubs', function (Blueprint $table) {
            $table->id('id_club');
            $table->string('nom');
            $table->unsignedBigInteger('foto');
            $table->foreign('foto')
                    ->references('id_foto')->on('fotos');
            $table->unsignedBigInteger('manager');
            $table->foreign('manager')
                    ->references('id_manager')->on('managers')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clubs');
    }
};
