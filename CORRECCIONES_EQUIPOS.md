# 🔧 CORRECCIONES APLICADAS - SISTEMA DE EQUIPOS

## ❌ PROBLEMAS DETECTADOS

### 1. No aparece el botón "Solicitar Unirse"
**Causa:** La relación pivot no cargaba correctamente el perfil

### 2. Error al mostrar rol del miembro
**Causa:** `$miembro->pivot->perfil` no estaba cargado

### 3. Error al crear equipo
**Posible causa:** Falta modelo EquipoParticipante

---

## ✅ CORRECCIONES APLICADAS

### 1️⃣ CREADO MODELO PIVOT

#### ✅ `app/Models/EquipoParticipante.php` - NUEVO
```php
class EquipoParticipante extends Pivot
{
    protected $table = 'equipo_participante';
    
    protected $fillable = [
        'equipo_id',
        'participante_id',
        'perfil_id',
        'estado',
    ];
    
    public function perfil(): BelongsTo
    {
        return $this->belongsTo(Perfil::class);
    }
}
```

**Función:** Permite cargar la relación con Perfil desde el pivot

---

### 2️⃣ ACTUALIZADO MODELO EQUIPO

#### ✅ `app/Models/Equipo.php` - MODIFICADO

**Cambios:**
```php
public function participantes(): BelongsToMany
{
    return $this->belongsToMany(Participante::class, 'equipo_participante')
                ->withPivot('perfil_id', 'estado')
                ->using(EquipoParticipante::class)  // ← NUEVO
                ->withTimestamps();
}

public function miembrosActivos()
{
    return $this->participantes()
                ->wherePivot('estado', 'activo')
                ->with('carrera');  // ← NUEVO
}
```

**Beneficio:** Ahora el pivot puede cargar relaciones

---

### 3️⃣ ACTUALIZADO EQUIPOCONTROLLER

#### ✅ `app/Http/Controllers/EquipoController.php` - MODIFICADO

**Método `show()` mejorado:**
```php
public function show(Equipo $equipo)
{
    // Cargar relaciones base
    $equipo->load([
        'evento', 
        'lider.user',
        'lider.carrera',
        'proyecto'
    ]);

    // Cargar participantes con perfil
    $equipo->load(['participantes' => function($query) {
        $query->with(['user', 'carrera'])
              ->withPivot('perfil_id', 'estado');
    }]);

    // Cargar los perfiles en el pivot
    foreach($equipo->participantes as $participante) {
        if ($participante->pivot->perfil_id) {
            $participante->pivot->load('perfil');
        }
    }
    
    // ... resto del código
}
```

**Beneficio:** Ahora carga correctamente el perfil de cada miembro

---

## 🧪 CÓMO PROBAR LAS CORRECCIONES

### TEST 1: Ver equipo existente
```
1. Ve a cualquier equipo existente
2. Deberías ver el ROL de cada miembro (Programador, Diseñador, etc.)
3. Si no eres miembro y hay cupo, deberías ver "Solicitar Unirse"
```

### TEST 2: Crear nuevo equipo
```
1. Login como participante
2. Ve a un evento abierto
3. Click "Ver Equipos"
4. Click "Crear Equipo"
5. Llena el formulario
6. Deberías poder crear sin errores
```

### TEST 3: Solicitar unirse
```
1. Login como otro participante
2. Ve a un equipo con cupo
3. Deberías ver botón "Solicitar Unirse"
4. Click y selecciona rol
5. Solicitud enviada exitosamente
```

---

## 🐛 SI AÚN HAY ERRORES

### Error: "perfil is null"
**Solución:** Ejecuta este SQL para verificar datos:
```sql
SELECT * FROM equipo_participante;
```
Verifica que `perfil_id` no sea NULL

### Error: "Class EquipoParticipante not found"
**Solución:**
```powershell
composer dump-autoload
```

### Error al crear equipo
**Verifica:**
1. Que tengas perfil de participante completo
2. Que el evento esté abierto
3. Que no tengas ya un equipo en ese evento
4. Revisa los logs en `storage/logs/laravel.log`

---

## 📝 ARCHIVOS MODIFICADOS

1. ✅ `app/Models/EquipoParticipante.php` - CREADO
2. ✅ `app/Models/Equipo.php` - ACTUALIZADO
3. ✅ `app/Http/Controllers/EquipoController.php` - ACTUALIZADO

---

## ⚠️ IMPORTANTE

Si los equipos existentes (de seeders) no tienen `perfil_id`, necesitas:

### OPCIÓN A: Re-ejecutar seeders
```powershell
php artisan migrate:fresh --seed
```
⚠️ Esto borrará todos los datos

### OPCIÓN B: Actualizar manualmente
```sql
-- Ver equipos sin perfil
SELECT * FROM equipo_participante WHERE perfil_id IS NULL;

-- Asignar perfil manualmente (ejemplo: perfil_id=1 es Programador)
UPDATE equipo_participante 
SET perfil_id = 1 
WHERE perfil_id IS NULL;
```

---

## ✅ RESULTADO ESPERADO

Después de estas correcciones:
- ✅ Ver rol de cada miembro en el equipo
- ✅ Botón "Solicitar Unirse" visible
- ✅ Crear equipo sin errores
- ✅ Solicitar unirse sin errores
- ✅ Aceptar/rechazar miembros sin errores

---

**¿Funcionó? Avísame si aún hay problemas.** 🚀
