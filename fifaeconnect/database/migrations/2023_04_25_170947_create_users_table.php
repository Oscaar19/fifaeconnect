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
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_usuari');
            $table->string('nom');
            $table->string('cognom');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken()->nullable();
            $table->string('foto');
            $table->boolean('fa')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
