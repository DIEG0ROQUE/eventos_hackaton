<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Carrera extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'clave',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Los perfiles de esta carrera
     */
    public function perfiles(): HasMany
    {
        return $this->hasMany(Perfil::class);
    }

    /**
     * Scope para carreras activas
     */
    public function scopeActivas($query)
    {
        return $query->where('activo', true);
    }
}