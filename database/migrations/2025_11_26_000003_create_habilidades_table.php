<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('habilidades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participante_id')->constrained('participantes')->onDelete('cascade');
            $table->string('nombre', 100);
            $table->integer('nivel')->default(50); // 0-100
            $table->string('color', 50)->default('bg-indigo-500');
            $table->integer('orden')->default(0);
            $table->timestamps();
            
            $table->index(['participante_id', 'orden']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('habilidades');
    }
};
