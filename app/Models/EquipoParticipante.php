<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EquipoParticipante extends Pivot
{
    protected $table = 'equipo_participante';

    protected $fillable = [
        'equipo_id',
        'participante_id',
        'perfil_id',
        'estado',
    ];

    /**
     * Perfil asignado en el equipo
     */
    public function perfil(): BelongsTo
    {
        return $this->belongsTo(Perfil::class);
    }

    /**
     * Equipo
     */
    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class);
    }

    /**
     * Participante
     */
    public function participante(): BelongsTo
    {
        return $this->belongsTo(Participante::class);
    }
}
