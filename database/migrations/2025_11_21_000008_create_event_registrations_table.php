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
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evento_id')->constrained('eventos')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('equipo_id')->nullable()->constrained('equipos')->nullOnDelete();
            $table->enum('estado', ['registrado', 'confirmado', 'cancelado', 'asistio'])->default('registrado');
            $table->dateTime('fecha_registro');
            $table->timestamps();
            
            // Un usuario solo puede registrarse una vez por evento
            $table->unique(['evento_id', 'user_id']);
            
            // Índices
            $table->index('evento_id');
            $table->index('user_id');
            $table->index('equipo_id');
            $table->index('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
    }
};