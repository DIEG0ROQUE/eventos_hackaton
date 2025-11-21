<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'evento_id',
        'nombre',
        'descripcion',
        'lider_id',
        'max_miembros',
        'estado',
        'avatar',
    ];

    /**
     * El evento al que pertenece
     */
    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class);
    }

    /**
     * El líder del equipo
     */
    public function lider(): BelongsTo
    {
        return $this->belongsTo(User::class, 'lider_id');
    }

    /**
     * Los miembros del equipo (relación many-to-many)
     */
    public function miembros(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'equipo_miembros', 'equipo_id', 'user_id')
                    ->withPivot('rol_en_equipo', 'especializacion', 'estado', 'fecha_union')
                    ->withTimestamps();
    }

    /**
     * Los miembros activos (solo aceptados)
     */
    public function miembrosActivos(): BelongsToMany
    {
        return $this->miembros()->wherePivot('estado', 'aceptado');
    }

    /**
     * Las solicitudes pendientes
     */
    public function solicitudesPendientes(): BelongsToMany
    {
        return $this->miembros()->wherePivot('estado', 'pendiente');
    }

    /**
     * El proyecto del equipo
     */
    public function proyecto(): HasOne
    {
        return $this->hasOne(Proyecto::class);
    }

    /**
     * Las notificaciones relacionadas al equipo
     */
    public function notificaciones(): HasMany
    {
        return $this->hasMany(Notificacion::class, 'equipo_id');
    }

    /**
     * SCOPES
     */
    public function scopeReclutando($query)
    {
        return $query->where('estado', 'reclutando');
    }

    public function scopeActivos($query)
    {
        return $query->whereIn('estado', ['reclutando', 'completo', 'activo']);
    }

    /**
     * HELPERS
     */
    public function estaCompleto(): bool
    {
        return $this->miembrosActivos()->count() >= $this->max_miembros;
    }

    public function puedeAceptarMiembros(): bool
    {
        return $this->estado === 'reclutando' &&
               $this->miembrosActivos()->count() < $this->max_miembros;
    }

    public function totalMiembros(): int
    {
        return $this->miembrosActivos()->count();
    }

    public function esLider(User $user): bool
    {
        return $this->lider_id === $user->id;
    }

    public function esMiembro(User $user): bool
    {
        return $this->miembrosActivos()->where('users.id', $user->id)->exists();
    }

    public function tieneSolicitudPendiente(User $user): bool
    {
        return $this->solicitudesPendientes()->where('users.id', $user->id)->exists();
    }

    /**
     * Agregar un miembro al equipo
     */
    public function agregarMiembro(User $user, string $rol = null, string $estado = 'pendiente')
    {
        return $this->miembros()->attach($user->id, [
            'rol_en_equipo' => $rol,
            'estado' => $estado,
            'fecha_union' => $estado === 'aceptado' ? now() : null,
        ]);
    }

    /**
     * Aceptar solicitud de un miembro
     */
    public function aceptarMiembro(User $user)
    {
        $this->miembros()->updateExistingPivot($user->id, [
            'estado' => 'aceptado',
            'fecha_union' => now(),
        ]);

        // Actualizar estado del equipo si está completo
        if ($this->estaCompleto()) {
            $this->update(['estado' => 'completo']);
        }
    }

    /**
     * Rechazar solicitud de un miembro
     */
    public function rechazarMiembro(User $user)
    {
        $this->miembros()->updateExistingPivot($user->id, [
            'estado' => 'rechazado',
        ]);
    }

    /**
     * Remover un miembro del equipo
     */
    public function removerMiembro(User $user)
    {
        $this->miembros()->detach($user->id);

        // Actualizar estado del equipo
        if ($this->estado === 'completo' && !$this->estaCompleto()) {
            $this->update(['estado' => 'reclutando']);
        }
    }
}