<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Perfil extends Model
{
    use HasFactory;

    protected $table = 'perfiles';

    protected $fillable = [
        'user_id',
        'carrera_id',
        'num_control',
        'telefono',
        'semestre',
        'biografia',
        'github_url',
        'linkedin_url',
        'portafolio_url',
        'avatar',
    ];

    /**
     * El usuario dueño del perfil
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * La carrera del perfil
     */
    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class);
    }

    /**
     * Verificar si el perfil está completo
     */
    public function estaCompleto(): bool
    {
        return !empty($this->num_control) &&
               !empty($this->carrera_id) &&
               !empty($this->telefono) &&
               !empty($this->semestre);
    }

    /**
     * Obtener el nombre de la carrera
     */
    public function getNombreCarreraAttribute()
    {
        return $this->carrera ? $this->carrera->nombre : 'Sin carrera';
    }
}