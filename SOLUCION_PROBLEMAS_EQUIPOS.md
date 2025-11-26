# 🐛 DIAGNÓSTICO Y SOLUCIONES - Sistema de Equipos

## ❌ PROBLEMAS IDENTIFICADOS

### PROBLEMA PRINCIPAL (Bloqueador Total)
**Error en logs:** `Call to undefined method App\Http\Controllers\EquipoController::middleware()`

**Línea del error:** EquipoController.php:18
**Causa:** Parece que en algún momento se agregó código en el constructor del controlador que no existe.

---

## ✅ SOLUCIONES PASO A PASO

### SOLUCIÓN 1: Verificar el EquipoController

El EquipoController actual NO tiene un constructor, pero el error indica que existe uno en la línea 18. Esto sugiere que:

1. O hay un archivo en caché corrupto
2. O el archivo fue modificado y guardado incorrectamente

**Acciones a realizar:**

```bash
# 1. Limpiar toda la caché de Laravel
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 2. Limpiar caché de Composer
composer dump-autoload

# 3. Reiniciar el servidor
php artisan serve
```

---

### SOLUCIÓN 2: Verificar tu Perfil de Participante

Para crear equipos, NECESITAS:
1. ✅ Estar autenticado
2. ✅ Tener rol de "participante"
3. ✅ Tener un perfil de participante completo (tabla `participantes`)

**Cómo verificar:**

```php
// Desde tinker (php artisan tinker)
$user = Auth::user();
$user->roles; // ¿Tiene rol "participante"?
$user->participante; // ¿Es null o tiene datos?
```

**Si tu participante es null, debes completar tu perfil:**
- Ve a: `/perfil/completar`
- Llena tu información (carrera, semestre, etc.)

---

### SOLUCIÓN 3: Verificar que el Middleware Esté Registrado

El middleware `profile.complete` ya está registrado correctamente en `bootstrap/app.php`:

```php
'profile.complete' => EnsureProfileComplete::class,
```

✅ Esto está BIEN.

---

### SOLUCIÓN 4: Verificar Eventos Abiertos

Para crear equipos o unirte a ellos, el evento DEBE estar "abierto".

**Verifica en la base de datos:**

```sql
SELECT id, nombre, estado, fecha_limite_registro 
FROM eventos 
WHERE estado = 'abierto';
```

Si no hay eventos abiertos, crea uno nuevo o cambia el estado de uno existente:

```sql
UPDATE eventos SET estado = 'abierto' WHERE id = 1;
```

---

## 🔧 SCRIPT DE VERIFICACIÓN

He creado `debug_equipos.php` en la raíz del proyecto. Para ejecutarlo:

**Opción 1 - Desde el navegador:**
1. Mueve `debug_equipos.php` a la carpeta `public/`
2. Accede a: `http://localhost:8000/debug_equipos.php`

**Opción 2 - Desde la terminal:**
```bash
php -f "debug_equipos.php"
```

Este script mostrará:
- Usuarios con rol participante
- Si tienen perfil completo
- Equipos existentes
- Eventos disponibles
- Perfiles disponibles

---

## 📋 CHECKLIST DE PROBLEMAS COMUNES

### ❌ "No puedo crear equipos"

**Verifica:**
- [ ] ¿Estás autenticado? → Inicia sesión
- [ ] ¿Tienes rol "participante"? → Verifica en la tabla `user_rol`
- [ ] ¿Tienes perfil completo? → Ve a `/perfil/completar`
- [ ] ¿El evento está abierto? → Verifica `eventos.estado = 'abierto'`
- [ ] ¿Ya tienes un equipo en ese evento? → Solo puedes tener 1 equipo por evento

---

### ❌ "No aparece el botón 'Solicitar Unirse'"

**Verifica:**
- [ ] ¿Estás autenticado?
- [ ] ¿Tienes perfil de participante?
- [ ] ¿Ya perteneces a otro equipo en ese evento?
- [ ] ¿El equipo tiene cupo disponible?
- [ ] ¿El evento está abierto?

**Condiciones para que aparezca el botón:**
```php
!$esMiembro && 
$equipo->puedeAceptarMiembros() && 
$equipo->evento->estaAbierto() && 
auth()->user()->participante &&
!$yaEstaEnOtroEquipo
```

---

### ❌ "No puedo registrarme en un evento"

**Verifica:**
- [ ] ¿Estás autenticado?
- [ ] ¿Tienes perfil completo?
- [ ] ¿El evento está abierto?
- [ ] ¿No estás ya registrado?

---

## 🚀 PASOS RECOMENDADOS (EN ORDEN)

### PASO 1: Limpiar Caché
```bash
cd "C:\Users\LENOVO\Documents\7MO SEMESTRE\WEB\hackathon-events"
php artisan optimize:clear
composer dump-autoload
```

### PASO 2: Verificar Usuario Actual
1. Inicia sesión en la aplicación
2. Ve a `/perfil`
3. Si no tienes perfil completo, complétalo en `/perfil/completar`

### PASO 3: Verificar Eventos
1. Ve a la lista de eventos (`/eventos`)
2. Busca un evento con estado "abierto"
3. Si no hay, como ADMIN crea uno o cambia el estado

### PASO 4: Intentar Crear Equipo
1. Ve al evento abierto
2. Click en "Ver Equipos"
3. Click en "Crear Equipo"
4. Llena el formulario
5. Submit

### PASO 5: Si hay Error, Revisar Log
```
storage/logs/laravel.log
```
Busca el último error y compártelo.

---

## 🔍 VERIFICACIÓN EN BASE DE DATOS

### Verificar tu usuario:
```sql
SELECT u.id, u.name, u.email, r.nombre as rol
FROM users u
JOIN user_rol ur ON u.id = ur.user_id
JOIN roles r ON ur.rol_id = r.id
WHERE u.email = 'TU_EMAIL@ejemplo.com';
```

### Verificar tu participante:
```sql
SELECT p.*, c.nombre as carrera
FROM participantes p
JOIN carreras c ON p.carrera_id = c.id
WHERE p.user_id = TU_USER_ID;
```

### Verificar eventos abiertos:
```sql
SELECT * FROM eventos WHERE estado = 'abierto';
```

### Verificar tus equipos:
```sql
SELECT e.*, eq.nombre as equipo
FROM participantes p
JOIN equipo_participante ep ON p.id = ep.participante_id
JOIN equipos eq ON ep.equipo_id = eq.id
WHERE p.user_id = TU_USER_ID;
```

---

## 💡 SOLUCIÓN RÁPIDA SI NADA FUNCIONA

Si después de hacer todo lo anterior aún no funciona, ejecuta:

```bash
# 1. Recrear la base de datos
php artisan migrate:fresh --seed

# 2. Limpiar todo
php artisan optimize:clear

# 3. Crear nuevo usuario de prueba
php artisan tinker
```

```php
// En tinker:
$user = App\Models\User::create([
    'name' => 'Test Participante',
    'email' => 'test@test.com',
    'password' => bcrypt('password')
]);

$user->asignarRol('participante');

$participante = App\Models\Participante::create([
    'user_id' => $user->id,
    'codigo_estudiante' => '12345678',
    'carrera_id' => 1,
    'semestre' => 5,
    'telefono' => '1234567890',
    'habilidades' => 'PHP, Laravel, JavaScript'
]);
```

---

## 📝 RESUMEN

**Los 3 problemas principales son:**

1. **Error de middleware/constructor** → Limpiar caché
2. **No tienes perfil completo** → Completar perfil
3. **Evento no está abierto** → Abrir evento o crear uno nuevo

**Ejecuta este comando primero:**
```bash
php artisan optimize:clear && composer dump-autoload
```

**Luego verifica:**
1. Tu perfil está completo
2. Hay un evento abierto
3. No tienes ya un equipo en ese evento

---

## 🆘 SI AÚN NO FUNCIONA

Comparte:
1. El último error en `storage/logs/laravel.log`
2. El resultado de ejecutar `debug_equipos.php`
3. Tu ID de usuario
4. Capturas de pantalla del error

¡Vamos a resolverlo! 🚀
