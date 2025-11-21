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
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evento_id')->constrained('eventos')->cascadeOnDelete();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->foreignId('lider_id')->constrained('users')->cascadeOnDelete();
            $table->integer('max_miembros')->default(5);
            $table->enum('estado', ['reclutando', 'completo', 'activo', 'inactivo'])->default('reclutando');
            $table->string('avatar')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('evento_id');
            $table->index('lider_id');
            $table->index('estado');
            $table->unique(['evento_id', 'nombre']); // Nombre único por evento
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};