<?php
// Archivo de prueba para verificar perfiles
// Ejecuta esto desde: php artisan tinker
// Y luego copia y pega cada comando

use App\Models\Perfil;
use App\Models\Evento;
use App\Models\Participante;

// 1. Ver todos los perfiles
echo "\n=== PERFILES DISPONIBLES ===\n";
$perfiles = Perfil::all();
foreach($perfiles as $perfil) {
    echo "ID: {$perfil->id} - {$perfil->nombre}\n";
}

// 2. Ver evento
echo "\n=== EVENTO ===\n";
$evento = Evento::find(1);
if($evento) {
    echo "ID: {$evento->id}\n";
    echo "Nombre: {$evento->nombre}\n";
    echo "Estado: {$evento->estado}\n";
    echo "Max miembros: {$evento->max_miembros_equipo}\n";
    echo "Min miembros: {$evento->min_miembros_equipo}\n";
} else {
    echo "No se encontró evento con ID 1\n";
}

// 3. Ver tu participante
echo "\n=== TU PARTICIPANTE ===\n";
$user = auth()->user();
if($user && $user->participante) {
    echo "Participante ID: {$user->participante->id}\n";
    echo "Nombre: {$user->name}\n";
    echo "Carrera: {$user->participante->carrera->nombre}\n";
} else {
    echo "No tienes perfil de participante\n";
}

// 4. Ver equipos del usuario
echo "\n=== TUS EQUIPOS ===\n";
if($user && $user->participante) {
    $equipos = $user->participante->equipos;
    echo "Total: {$equipos->count()}\n";
    foreach($equipos as $equipo) {
        echo "- {$equipo->nombre} (Evento: {$equipo->evento->nombre})\n";
    }
}
