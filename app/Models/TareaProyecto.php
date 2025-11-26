<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TareaProyecto extends Model
{
    protected $table = 'tareas_proyecto';
    
    protected $fillable = [
        'proyecto_id',
        'asignado_a',
        'nombre',
        'descripcion',
        'estado',
        'orden',
    ];

    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function asignado(): BelongsTo
    {
        return $this->belongsTo(Participante::class, 'asignado_a');
    }
}
