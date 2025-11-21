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
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('tipo'); // invitacion_equipo, nuevo_evento, etc.
            $table->string('titulo');
            $table->text('mensaje');
            $table->json('datos_adicionales')->nullable(); // {equipo_id: 1, evento_id: 2}
            $table->boolean('leida')->default(false);
            $table->string('url_accion')->nullable(); // /equipos/1
            $table->timestamps();
            
            // Índices
            $table->index('user_id');
            $table->index('leida');
            $table->index('tipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};