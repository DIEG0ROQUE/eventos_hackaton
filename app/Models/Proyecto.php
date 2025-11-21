<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proyecto extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipo_id',
        'evento_id',
        'nombre',
        'descripcion',
        'problema_a_resolver',
        'solucion_propuesta',
        'tecnologias_usadas',
        'url_demo',
        'url_video',
        'url_repositorio',
        'estado',
        'puntuacion_final',
        'lugar_obtenido',
    ];

    protected $casts = [
        'tecnologias_usadas' => 'array',
        'puntuacion_final' => 'decimal:2',
    ];

    /**
     * El equipo dueño del proyecto
     */
    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class);
    }

    /**
     * El evento del proyecto
     */
    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class);
    }

    /**
     * SCOPES
     */
    public function scopeCompletados($query)
    {
        return $query->where('estado', 'completado');
    }

    public function scopePresentados($query)
    {
        return $query->where('estado', 'presentado');
    }

    public function scopeGanadores($query)
    {
        return $query->whereNotNull('lugar_obtenido')
                    ->orderBy('lugar_obtenido', 'asc');
    }

    /**
     * HELPERS
     */
    public function estaCompletado(): bool
    {
        return $this->estado === 'completado';
    }

    public function fuePresentado(): bool
    {
        return $this->estado === 'presentado';
    }

    public function esGanador(): bool
    {
        return !is_null($this->lugar_obtenido);
    }

    public function getMedallaAttribute(): ?string
    {
        return match($this->lugar_obtenido) {
            1 => '🥇',
            2 => '🥈',
            3 => '🥉',
            default => null,
        };
    }

    public function getLugarTextoAttribute(): ?string
    {
        if (!$this->lugar_obtenido) {
            return null;
        }

        return match($this->lugar_obtenido) {
            1 => '1er Lugar',
            2 => '2do Lugar',
            3 => '3er Lugar',
            default => $this->lugar_obtenido . '° Lugar',
        };
    }
}