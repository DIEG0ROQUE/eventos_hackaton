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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre del equipo (ej: "CodeMasters")
            $table->text('description')->nullable(); // Descripción del equipo
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete(); // Evento al que pertenece
            $table->foreignId('leader_id')->constrained('users')->cascadeOnDelete(); // Líder del equipo
            $table->integer('max_members')->default(5); // Máximo de miembros
            $table->enum('status', ['recruiting', 'full', 'active', 'inactive'])->default('recruiting');
            
            // Roles disponibles (JSON)
            $table->json('available_roles')->nullable(); // Roles que buscan
            
            // Tecnologías/Habilidades del equipo
            $table->json('technologies')->nullable(); // Array de tecnologías
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index('event_id');
            $table->index('leader_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
