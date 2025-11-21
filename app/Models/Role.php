<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Los usuarios que tienen este rol
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user')
                    ->withTimestamps();
    }

    /**
     * Helpers estáticos
     */
    public static function estudiante()
    {
        return static::where('name', 'estudiante')->first();
    }

    public static function admin()
    {
        return static::where('name', 'admin')->first();
    }

    public static function juez()
    {
        return static::where('name', 'juez')->first();
    }
}