<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ==================== RELACIONES ====================

    /**
     * El perfil del usuario
     */
    public function perfil(): HasOne
    {
        return $this->hasOne(Perfil::class);
    }

    /**
     * Los roles del usuario
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user')
                    ->withTimestamps();
    }

    /**
     * Los equipos donde es líder
     */
    public function equiposLiderados(): HasMany
    {
        return $this->hasMany(Equipo::class, 'lider_id');
    }

    /**
     * Los equipos donde es miembro (many-to-many)
     */
    public function equipos(): BelongsToMany
    {
        return $this->belongsToMany(Equipo::class, 'equipo_miembros', 'user_id', 'equipo_id')
                    ->withPivot('rol_en_equipo', 'especializacion', 'estado', 'fecha_union')
                    ->withTimestamps();
    }

    /**
     * Los equipos activos (solo aceptados)
     */
    public function equiposActivos(): BelongsToMany
    {
        return $this->equipos()->wherePivot('estado', 'aceptado');
    }

    /**
     * Los eventos a los que está inscrito
     */
    public function eventos(): BelongsToMany
    {
        return $this->belongsToMany(Evento::class, 'event_registrations')
                    ->withPivot('estado', 'fecha_registro', 'equipo_id')
                    ->withTimestamps();
    }

    /**
     * Las inscripciones del usuario
     */
    public function inscripciones(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    /**
     * Los eventos creados por el usuario (si es admin)
     */
    public function eventosCreados(): HasMany
    {
        return $this->hasMany(Evento::class, 'created_by');
    }

    /**
     * Las notificaciones del usuario
     */
    public function notificaciones(): HasMany
    {
        return $this->hasMany(Notificacion::class);
    }

    /**
     * Las notificaciones no leídas
     */
    public function notificacionesNoLeidas(): HasMany
    {
        return $this->notificaciones()->where('leida', false);
    }

    // ==================== HELPERS DE ROLES ====================

    /**
     * Asignar un rol al usuario
     */
    public function asignarRol(string $roleName)
    {
        $rol = Role::where('name', $roleName)->first();
        if ($rol) {
            $this->roles()->syncWithoutDetaching([$rol->id]);
        }
    }

    /**
     * Verificar si tiene un rol
     */
    public function tieneRol(string $roleName): bool
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    /**
     * Es administrador?
     */
    public function isAdmin(): bool
    {
        return $this->tieneRol('admin');
    }

    /**
     * Es estudiante?
     */
    public function isEstudiante(): bool
    {
        return $this->tieneRol('estudiante');
    }

    /**
     * Es juez?
     */
    public function isJuez(): bool
    {
        return $this->tieneRol('juez');
    }

    // ==================== HELPERS DE PERFIL ====================

    /**
     * Tiene perfil completo?
     */
    public function tienePerfilCompleto(): bool
    {
        return $this->perfil && $this->perfil->estaCompleto();
    }

    /**
     * Obtener el avatar o uno por defecto
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->perfil && $this->perfil->avatar) {
            return asset('storage/' . $this->perfil->avatar);
        }

        // Avatar por defecto usando UI Avatars
        $nombre = urlencode($this->name);
        return "https://ui-avatars.com/api/?name={$nombre}&size=200&background=3b82f6&color=fff";
    }

    /**
     * Obtener el número de control si existe
     */
    public function getNumControlAttribute(): ?string
    {
        return $this->perfil ? $this->perfil->num_control : null;
    }

    /**
     * Obtener el nombre de la carrera
     */
    public function getNombreCarreraAttribute(): string
    {
        return $this->perfil && $this->perfil->carrera 
            ? $this->perfil->carrera->nombre 
            : 'Sin carrera';
    }

    // ==================== HELPERS DE EQUIPOS ====================

    /**
     * Está en un equipo específico?
     */
    public function estaEnEquipo(Equipo $equipo): bool
    {
        return $this->equiposActivos()->where('equipos.id', $equipo->id)->exists();
    }

    /**
     * Es líder de un equipo específico?
     */
    public function esLiderDe(Equipo $equipo): bool
    {
        return $equipo->lider_id === $this->id;
    }

    /**
     * Tiene solicitud pendiente en un equipo?
     */
    public function tieneSolicitudPendienteEn(Equipo $equipo): bool
    {
        return $this->equipos()
                    ->where('equipos.id', $equipo->id)
                    ->wherePivot('estado', 'pendiente')
                    ->exists();
    }

    /**
     * Obtener equipos activos en un evento específico
     */
    public function equiposEnEvento(Evento $evento): BelongsToMany
    {
        return $this->equiposActivos()->where('evento_id', $evento->id);
    }

    /**
     * Tiene equipo en un evento?
     */
    public function tieneEquipoEnEvento(Evento $evento): bool
    {
        return $this->equiposEnEvento($evento)->exists();
    }

    // ==================== HELPERS DE EVENTOS ====================

    /**
     * Está inscrito en un evento?
     */
    public function estaInscritoEn(Evento $evento): bool
    {
        return $this->inscripciones()
                    ->where('evento_id', $evento->id)
                    ->exists();
    }

    /**
     * Puede inscribirse en un evento?
     */
    public function puedeInscribirseEn(Evento $evento): bool
    {
        return !$this->estaInscritoEn($evento) && $evento->puedeRegistrarse();
    }

    /**
     * Inscribirse en un evento
     */
    public function inscribirseEn(Evento $evento)
    {
        return $this->inscripciones()->create([
            'evento_id' => $evento->id,
            'estado' => 'registrado',
            'fecha_registro' => now(),
        ]);
    }

    // ==================== HELPERS DE NOTIFICACIONES ====================

    /**
     * Cantidad de notificaciones no leídas
     */
    public function cantidadNotificacionesNoLeidas(): int
    {
        return $this->notificacionesNoLeidas()->count();
    }

    /**
     * Marcar todas las notificaciones como leídas
     */
    public function marcarNotificacionesComoLeidas()
    {
        $this->notificacionesNoLeidas()->update(['leida' => true]);
    }
}