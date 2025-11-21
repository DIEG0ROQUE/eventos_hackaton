<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'duration_hours',
        'max_teams',
        'max_team_members',
        'type',
        'status',
        'prizes',
        'requirements',
        'schedule',
        'resources_url',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'prizes' => 'array',
        'requirements' => 'array',
        'schedule' => 'array',
    ];

    /**
     * Relación con el usuario creador
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relación con los equipos del evento
     */
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    /**
     * Relación con los registros al evento
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    /**
     * Obtener los participantes del evento
     */
    public function participants()
    {
        return $this->belongsToMany(User::class, 'event_registrations')
                    ->withPivot('status', 'registered_at')
                    ->withTimestamps();
    }

    /**
     * Verificar si el evento está abierto para registro
     */
    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    /**
     * Verificar si el evento está en progreso
     */
    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    /**
     * Verificar si el evento ha finalizado
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Obtener el número total de participantes
     */
    public function getTotalParticipantsAttribute(): int
    {
        return $this->registrations()->where('status', 'confirmed')->count();
    }

    /**
     * Verificar si quedan espacios disponibles
     */
    public function hasAvailableSpots(): bool
    {
        if (!$this->max_teams) {
            return true;
        }
        return $this->teams()->count() < $this->max_teams;
    }

    /**
     * Scope para eventos abiertos
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    /**
     * Scope para eventos futuros
     */
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now());
    }

    /**
     * Scope para eventos activos
     */
    public function scopeActive($query)
    {
        return $query->whereIn('status', ['open', 'in_progress']);
    }
}
