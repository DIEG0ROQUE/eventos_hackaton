<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';

    protected $fillable = [
        'user_id',
        'tipo',
        'titulo',
        'mensaje',
        'datos_adicionales',
        'leida',
        'url_accion',
    ];

    protected $casts = [
        'datos_adicionales' => 'array',
        'leida' => 'boolean',
    ];

    /**
     * El usuario destinatario
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * SCOPES
     */
    public function scopeNoLeidas($query)
    {
        return $query->where('leida', false);
    }

    public function scopeRecientes($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopePorTipo($query, string $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * HELPERS
     */
    public function marcarComoLeida()
    {
        $this->update(['leida' => true]);
    }

    /**
     * Crear notificación de invitación a equipo
     */
    public static function invitacionEquipo(User $user, Equipo $equipo)
    {
        return static::create([
            'user_id' => $user->id,
            'tipo' => 'invitacion_equipo',
            'titulo' => 'Invitación a equipo',
            'mensaje' => "Te han invitado a unirte al equipo {$equipo->nombre}",
            'datos_adicionales' => [
                'equipo_id' => $equipo->id,
                'evento_id' => $equipo->evento_id,
            ],
            'url_accion' => route('equipos.show', $equipo),
        ]);
    }

    /**
     * Crear notificación de nuevo evento
     */
    public static function nuevoEvento(User $user, Evento $evento)
    {
        return static::create([
            'user_id' => $user->id,
            'tipo' => 'nuevo_evento',
            'titulo' => 'Nuevo evento disponible',
            'mensaje' => "Nuevo evento: {$evento->titulo}",
            'datos_adicionales' => [
                'evento_id' => $evento->id,
            ],
            'url_accion' => route('eventos.show', $evento),
        ]);
    }

    /**
     * Crear notificación de solicitud aceptada
     */
    public static function solicitudAceptada(User $user, Equipo $equipo)
    {
        return static::create([
            'user_id' => $user->id,
            'tipo' => 'solicitud_aceptada',
            'titulo' => 'Solicitud aceptada',
            'mensaje' => "Tu solicitud para unirte a {$equipo->nombre} ha sido aceptada",
            'datos_adicionales' => [
                'equipo_id' => $equipo->id,
            ],
            'url_accion' => route('equipos.show', $equipo),
        ]);
    }
}