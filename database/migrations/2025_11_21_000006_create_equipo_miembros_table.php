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
        Schema::create('equipo_miembros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipo_id')->constrained('equipos')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('rol_en_equipo')->nullable(); // Programador, Diseñador, etc.
            $table->string('especializacion')->nullable(); // Frontend, Backend, etc.
            $table->enum('estado', ['pendiente', 'aceptado', 'rechazado', 'activo'])->default('pendiente');
            $table->dateTime('fecha_union')->nullable();
            $table->timestamps();
            
            // Un usuario solo puede estar una vez en un equipo
            $table->unique(['equipo_id', 'user_id']);
            
            // Índices
            $table->index('equipo_id');
            $table->index('user_id');
            $table->index('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipo_miembros');
    }
};