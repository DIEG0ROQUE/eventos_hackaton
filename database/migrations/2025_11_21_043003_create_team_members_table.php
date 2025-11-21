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
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained('teams')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('role'); // Rol en el equipo (ej: "Programador", "Diseñador")
            $table->string('specialization')->nullable(); // Especialización (ej: "Ing. Software")
            $table->enum('status', ['pending', 'accepted', 'rejected', 'active', 'inactive'])->default('active');
            $table->timestamp('joined_at')->nullable(); // Fecha de unión
            $table->timestamps();
            
            // Un usuario solo puede estar una vez en un equipo
            $table->unique(['team_id', 'user_id']);
            
            // Índices
            $table->index('team_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};
