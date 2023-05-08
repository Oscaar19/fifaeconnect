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
        Schema::create('goldens', function (Blueprint $table) {
            $table->unsignedBigInteger('id_valorador');            
            $table->foreign('id_valorador')
                    ->references('id_usuari')->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->unsignedBigInteger('id_valorat');            
            $table->foreign('id_valorat')
                    ->references('id_usuari')->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->unique(['id_valorador', 'id_valorat']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goldens');
    }
};
