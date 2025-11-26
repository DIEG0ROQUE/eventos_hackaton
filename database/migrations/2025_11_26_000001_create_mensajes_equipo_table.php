<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mensajes_equipo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipo_id')->constrained('equipos')->onDelete('cascade');
            $table->foreignId('participante_id')->constrained('participantes')->onDelete('cascade');
            $table->text('mensaje');
            $table->timestamps();
            
            $table->index(['equipo_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensajes_equipo');
    }
};
