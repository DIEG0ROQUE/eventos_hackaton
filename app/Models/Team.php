<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'event_id',
        'leader_id',
        'max_members',
        'status',
        'available_roles',
        'technologies',
    ];

    protected $casts = [
        'available_roles' => 'array',
        'technologies' => 'array',
    ];

    /**
     * Relación con el evento
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Relación con el líder del equipo
     */
    public function leader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    /**
     * Relación con los miembros del equipo
     */
    public function teamMembers(): HasMany
    {
        return $this->hasMany(TeamMember::class);
    }

    /**
     * Relación muchos a muchos con usuarios
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'team_members')
                    ->withPivot('role', 'specialization', 'status', 'joined_at')
                    ->withTimestamps();
    }

    /**
     * Obtener miembros activos
     */
    public function activeMembers()
    {
        return $this->members()->wherePivot('status', 'active');
    }

    /**
     * Verificar si el equipo está completo
     */
    public function isFull(): bool
    {
        return $this->activeMembers()->count() >= $this->max_members;
    }

    /**
     * Verificar si está reclutando
     */
    public function isRecruiting(): bool
    {
        return $this->status === 'recruiting' && !$this->isFull();
    }

    /**
     * Obtener espacios disponibles
     */
    public function getAvailableSpotsAttribute(): int
    {
        return max(0, $this->max_members - $this->activeMembers()->count());
    }

    /**
     * Verificar si un usuario es el líder
     */
    public function isLeader(User $user): bool
    {
        return $this->leader_id === $user->id;
    }

    /**
     * Verificar si un usuario es miembro
     */
    public function hasMember(User $user): bool
    {
        return $this->members()->where('user_id', $user->id)->exists();
    }

    /**
     * Agregar un miembro al equipo
     */
    public function addMember(User $user, string $role, ?string $specialization = null): bool
    {
        if ($this->isFull() || $this->hasMember($user)) {
            return false;
        }

        $this->members()->attach($user->id, [
            'role' => $role,
            'specialization' => $specialization,
            'status' => 'active',
            'joined_at' => now(),
        ]);

        // Actualizar estado si está completo
        if ($this->isFull()) {
            $this->update(['status' => 'full']);
        }

        return true;
    }

    /**
     * Remover un miembro del equipo
     */
    public function removeMember(User $user): bool
    {
        if (!$this->hasMember($user) || $this->isLeader($user)) {
            return false;
        }

        $this->members()->detach($user->id);

        // Actualizar estado si ya no está completo
        if ($this->status === 'full' && !$this->isFull()) {
            $this->update(['status' => 'recruiting']);
        }

        return true;
    }

    /**
     * Scope para equipos que están reclutando
     */
    public function scopeRecruiting($query)
    {
        return $query->where('status', 'recruiting');
    }

    /**
     * Scope para equipos de un evento específico
     */
    public function scopeForEvent($query, $eventId)
    {
        return $query->where('event_id', $eventId);
    }
}

