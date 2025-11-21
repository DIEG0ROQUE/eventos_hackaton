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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion');
            $table->enum('tipo', ['hackathon', 'datathon', 'concurso', 'workshop'])->default('hackathon');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->dateTime('fecha_limite_registro');
            $table->string('ubicacion')->nullable();
            $table->boolean('es_virtual')->default(false);
            $table->integer('duracion_horas')->nullable();
            $table->integer('max_participantes')->nullable();
            $table->integer('min_miembros_equipo')->default(3);
            $table->integer('max_miembros_equipo')->default(5);
            $table->enum('estado', ['draft', 'abierto', 'en_progreso', 'cerrado', 'completado'])->default('draft');
            $table->string('imagen_portada')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para mejorar rendimiento
            $table->index('estado');
            $table->index('fecha_inicio');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};