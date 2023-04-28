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
        Schema::create('xarxes', function (Blueprint $table) {
            $table->id('id_xarxa');
            $table->unsignedBigInteger('id_usuari');     
            $table->foreign('id_usuari')
                    ->references('id_usuari')->on('usuaris')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->string('link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('xarxes');
    }
};
