<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MensajeEquipo extends Model
{
    protected $table = 'mensajes_equipo';
    
    protected $fillable = [
        'equipo_id',
        'participante_id',
        'mensaje',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class);
    }

    public function participante(): BelongsTo
    {
        return $this->belongsTo(Participante::class);
    }
}
