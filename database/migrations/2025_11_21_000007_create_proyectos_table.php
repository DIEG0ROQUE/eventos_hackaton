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
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipo_id')->unique()->constrained('equipos')->cascadeOnDelete();
            $table->foreignId('evento_id')->constrained('eventos')->cascadeOnDelete();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->text('problema_a_resolver')->nullable();
            $table->text('solucion_propuesta')->nullable();
            $table->json('tecnologias_usadas')->nullable(); // ["Laravel", "Vue.js", "MySQL"]
            $table->string('url_demo')->nullable();
            $table->string('url_video')->nullable();
            $table->string('url_repositorio')->nullable();
            $table->enum('estado', ['en_desarrollo', 'completado', 'presentado'])->default('en_desarrollo');
            $table->decimal('puntuacion_final', 5, 2)->nullable();
            $table->integer('lugar_obtenido')->nullable(); // 1, 2, 3
            $table->timestamps();
            
            // Índices
            $table->index('equipo_id');
            $table->index('evento_id');
            $table->index('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};