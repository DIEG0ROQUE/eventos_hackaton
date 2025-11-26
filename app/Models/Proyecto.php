<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proyecto extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipo_id',
        'evento_id',
        'nombre',
        'descripcion',
        'link_repositorio',
        'link_demo',
        'link_presentacion',
        'tecnologias',
        'calificacion_final',
        'posicion_final',
    ];

    protected $casts = [
        'calificacion_final' => 'decimal:2',
    ];

    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class);
    }

    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class);
    }

    public function calificaciones(): HasMany
    {
        return $this->hasMany(Calificacion::class);
    }

    public function tareas(): HasMany
    {
        return $this->hasMany(TareaProyecto::class);
    }

    public function calcularCalificacionFinal(): float
    {
        $criterios = $this->evento->criterios;
        $calificacionTotal = 0;

        foreach ($criterios as $criterio) {
            $promedioCalificaciones = $this->calificaciones()
                ->where('criterio_id', $criterio->id)
                ->avg('puntuacion');
            
            if ($promedioCalificaciones) {
                $calificacionTotal += ($promedioCalificaciones * $criterio->ponderacion) / 100;
            }
        }

        return round($calificacionTotal, 2);
    }
}