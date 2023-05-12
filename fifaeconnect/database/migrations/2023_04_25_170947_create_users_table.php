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
            $table->id();
            $table->string('nom');
            $table->string('cognom')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken()->nullable();
            $table->unsignedBigInteger('foto_id')->nullable();
            $table->foreign('foto_id')
                    ->references('id')->on('fotos')
                    ->onUpdate('cascade');
            $table->boolean('fa')->nullable();
            $table->unsignedBigInteger('club_id')->nullable();
            $table->foreign('club_id')
                    ->references('id')->on('clubs')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
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
