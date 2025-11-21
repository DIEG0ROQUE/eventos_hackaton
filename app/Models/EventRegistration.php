<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'evento_id',
        'user_id',
        'equipo_id',
        'estado',
        'fecha_registro',
    ];

    protected $casts = [
        'fecha_registro' => 'datetime',
    ];

    /**
     * El evento
     */
    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class);
    }

    /**
     * El usuario inscrito
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * El equipo (si ya tiene uno)
     */
    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class);
    }

    /**
     * SCOPES
     */
    public function scopeConfirmados($query)
    {
        return $query->where('estado', 'confirmado');
    }

    public function scopeSinEquipo($query)
    {
        return $query->whereNull('equipo_id');
    }

    /**
     * HELPERS
     */
    public function estaConfirmado(): bool
    {
        return $this->estado === 'confirmado';
    }

    public function tieneEquipo(): bool
    {
        return !is_null($this->equipo_id);
    }
}