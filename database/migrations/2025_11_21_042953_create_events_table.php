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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Título del evento (ej: "Hackaton 2025")
            $table->text('description'); // Descripción completa
            $table->dateTime('start_date'); // Fecha de inicio
            $table->dateTime('end_date'); // Fecha de finalización
            $table->string('location'); // Ubicación física
            $table->integer('duration_hours')->default(48); // Duración en horas
            $table->integer('max_teams')->nullable(); // Máximo de equipos permitidos
            $table->integer('max_team_members')->default(5); // Máximo de miembros por equipo
            $table->string('type')->default('programming'); // Tipo de evento
            $table->enum('status', ['draft', 'open', 'in_progress', 'closed', 'completed'])->default('draft');
            
            // Premios (JSON para flexibilidad)
            $table->json('prizes')->nullable(); // Array de premios
            
            // Requisitos
            $table->json('requirements')->nullable(); // Array de requisitos
            
            // Cronograma
            $table->json('schedule')->nullable(); // Timeline del evento
            
            // Recursos
            $table->text('resources_url')->nullable(); // URL de descarga de recursos
            
            // Auditoría
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes(); // Para borrado suave
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
