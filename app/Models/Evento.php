<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Evento extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'titulo',
        'descripcion',
        'tipo',
        'fecha_inicio',
        'fecha_fin',
        'fecha_limite_registro',
        'ubicacion',
        'es_virtual',
        'duracion_horas',
        'max_participantes',
        'min_miembros_equipo',
        'max_miembros_equipo',
        'estado',
        'imagen_portada',
        'created_by',
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'fecha_limite_registro' => 'datetime',
        'es_virtual' => 'boolean',
    ];

    /**
     * El usuario que creó el evento
     */
    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Los equipos de este evento
     */
    public function equipos(): HasMany
    {
        return $this->hasMany(Equipo::class);
    }

    /**
     * Los proyectos de este evento
     */
    public function proyectos(): HasMany
    {
        return $this->hasMany(Proyecto::class);
    }

    /**
     * Las inscripciones a este evento
     */
    public function registros(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    /**
     * Los participantes inscritos
     */
    public function participantes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_registrations')
                    ->withPivot('estado', 'fecha_registro', 'equipo_id')
                    ->withTimestamps();
    }

    /**
     * SCOPES
     */
    public function scopeAbiertos($query)
    {
        return $query->where('estado', 'abierto');
    }

    public function scopeActivos($query)
    {
        return $query->whereIn('estado', ['abierto', 'en_progreso']);
    }

    public function scopeProximos($query)
    {
        return $query->where('fecha_inicio', '>', Carbon::now())
                    ->where('estado', 'abierto')
                    ->orderBy('fecha_inicio', 'asc');
    }

    /**
     * HELPERS
     */
    public function estaAbierto(): bool
    {
        return $this->estado === 'abierto' &&
               Carbon::now()->lte($this->fecha_limite_registro);
    }

    public function puedeRegistrarse(): bool
    {
        if (!$this->estaAbierto()) {
            return false;
        }

        if ($this->max_participantes) {
            $registrados = $this->registros()->count();
            return $registrados < $this->max_participantes;
        }

        return true;
    }

    public function totalParticipantes(): int
    {
        return $this->registros()->count();
    }

    public function totalEquipos(): int
    {
        return $this->equipos()->count();
    }

    /**
     * Obtener el estado en español
     */
    public function getEstadoTextoAttribute(): string
    {
        $estados = [
            'draft' => 'Borrador',
            'abierto' => 'Abierto',
            'en_progreso' => 'En Progreso',
            'cerrado' => 'Cerrado',
            'completado' => 'Completado',
        ];

        return $estados[$this->estado] ?? $this->estado;
    }

    /**
     * Obtener el tipo en español
     */
    public function getTipoTextoAttribute(): string
    {
        $tipos = [
            'hackathon' => 'Hackathon',
            'datathon' => 'Datathon',
            'concurso' => 'Concurso',
            'workshop' => 'Workshop',
        ];

        return $tipos[$this->tipo] ?? $this->tipo;
    }
}