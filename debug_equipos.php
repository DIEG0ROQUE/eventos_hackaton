<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Participante;
use App\Models\Equipo;
use App\Models\Perfil;

echo "=== DEBUG: Sistema de Equipos ===\n\n";

// 1. Verificar usuarios con rol participante
echo "1. USUARIOS CON ROL PARTICIPANTE:\n";
$users = User::whereHas('roles', function($q) {
    $q->where('nombre', 'participante');
})->with('participante')->get();

foreach ($users as $user) {
    echo "  - Usuario: {$user->name} (ID: {$user->id})\n";
    echo "    Email: {$user->email}\n";
    echo "    Tiene Participante: " . ($user->participante ? "SÍ (ID: {$user->participante->id})" : "NO") . "\n";
    if ($user->participante) {
        echo "    Carrera: {$user->participante->carrera->nombre}\n";
    }
    echo "\n";
}

// 2. Verificar perfiles
echo "\n2. PERFILES DISPONIBLES:\n";
$perfiles = Perfil::all();
foreach ($perfiles as $perfil) {
    echo "  - {$perfil->nombre} (ID: {$perfil->id})\n";
}

// 3. Verificar equipos
echo "\n3. EQUIPOS EXISTENTES:\n";
$equipos = Equipo::with(['evento', 'lider.user', 'participantes'])->get();
foreach ($equipos as $equipo) {
    echo "  - Equipo: {$equipo->nombre} (ID: {$equipo->id})\n";
    echo "    Evento: {$equipo->evento->nombre}\n";
    echo "    Líder: {$equipo->lider->user->name}\n";
    echo "    Miembros: {$equipo->participantes->count()}/{$equipo->max_miembros}\n";
    
    // Verificar datos pivot
    foreach ($equipo->participantes as $participante) {
        echo "      * {$participante->user->name}\n";
        echo "        Perfil ID: {$participante->pivot->perfil_id}\n";
        echo "        Estado: {$participante->pivot->estado}\n";
    }
    echo "\n";
}

// 4. Verificar eventos
echo "\n4. EVENTOS:\n";
$eventos = \App\Models\Evento::all();
foreach ($eventos as $evento) {
    echo "  - {$evento->nombre}\n";
    echo "    Estado: {$evento->estado}\n";
    echo "    Abierto: " . ($evento->estaAbierto() ? "SÍ" : "NO") . "\n";
    echo "    Min miembros: {$evento->min_miembros_equipo}\n";
    echo "    Max miembros: {$evento->max_miembros_equipo}\n";
    echo "\n";
}

echo "\n=== FIN DEBUG ===\n";
