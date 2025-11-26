<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Habilidad extends Model
{
    protected $table = 'habilidades';
    
    protected $fillable = [
        'participante_id',
        'nombre',
        'nivel',
        'color',
        'orden',
    ];

    protected $casts = [
        'nivel' => 'integer',
        'orden' => 'integer',
    ];

    public function participante(): BelongsTo
    {
        return $this->belongsTo(Participante::class);
    }

    /**
     * Colores disponibles para las habilidades
     */
    public static function coloresDisponibles(): array
    {
        return [
            'bg-red-500' => 'Rojo',
            'bg-orange-500' => 'Naranja',
            'bg-yellow-500' => 'Amarillo',
            'bg-green-500' => 'Verde',
            'bg-teal-500' => 'Teal',
            'bg-blue-500' => 'Azul',
            'bg-indigo-500' => 'Índigo',
            'bg-purple-500' => 'Morado',
            'bg-pink-500' => 'Rosa',
            'bg-cyan-500' => 'Cyan',
        ];
    }
}
