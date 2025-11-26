# 🔍 PRUEBAS SQL PARA DIAGNOSTICAR EQUIPOS

Ejecuta estos comandos en MySQL para verificar el estado de la base de datos:

## 1. Verificar que existen perfiles
```sql
SELECT * FROM perfiles;
```
**Resultado esperado:** Deberías ver: Programador, Diseñador, Analista de Negocios, etc.

## 2. Verificar equipos existentes
```sql
SELECT id, nombre, evento_id, lider_id, max_miembros 
FROM equipos;
```
**Resultado esperado:** Ver 3 equipos (Los Innovadores, Code Warriors, Tech Titans)

## 3. Verificar miembros de equipos CON PERFILES
```sql
SELECT 
    ep.equipo_id,
    ep.participante_id,
    ep.perfil_id,
    ep.estado,
    p.nombre as nombre_perfil,
    u.name as nombre_usuario
FROM equipo_participante ep
LEFT JOIN perfiles p ON ep.perfil_id = p.id
LEFT JOIN participantes par ON ep.participante_id = par.id
LEFT JOIN users u ON par.user_id = u.id
ORDER BY ep.equipo_id;
```
**Resultado esperado:** Cada registro debe tener un `perfil_id` y mostrar el nombre del perfil

## 4. Si perfil_id es NULL, corregir:
```sql
-- Asignar perfil "Programador" (id=1) a todos los que no tienen
UPDATE equipo_participante 
SET perfil_id = 1 
WHERE perfil_id IS NULL;
```

## 5. Verificar evento abierto
```sql
SELECT id, nombre, estado, fecha_inicio, fecha_fin 
FROM eventos 
WHERE nombre = 'Hackathon Primavera 2025';
```
**Resultado esperado:** estado = 'abierto'

## 6. Si el evento no está abierto:
```sql
UPDATE eventos 
SET estado = 'abierto' 
WHERE nombre = 'Hackathon Primavera 2025';
```

---

# 🐛 DEBUGGING EN EL NAVEGADOR

## Crear equipo - Ver errores en consola:

1. Abre navegador
2. Presiona F12 (DevTools)
3. Ve a la pestaña "Console"
4. Intenta crear un equipo
5. **Copia cualquier error que aparezca en rojo**

## Ver detalle de equipo - Ver errores:

1. Entra a cualquier equipo existente
2. Presiona F12
3. Ve a "Console"
4. **Copia cualquier error**

---

# 🧪 PRUEBA PASO A PASO

## TEST 1: Verificar que puedes ver equipos
```
URL: /equipos/evento/1
¿Se cargan los equipos? SI / NO
¿Cuántos equipos ves? ___
```

## TEST 2: Verificar perfiles en detalle
```
URL: /equipos/1
¿Se ve el rol de cada miembro? SI / NO
¿Dice "Programador", "Diseñador", etc.? SI / NO
¿O dice "Sin perfil asignado"? SI / NO
```

## TEST 3: Ver botón "Solicitar Unirse"
```
Login como: maria.lopez@alumno.com
Ve a un equipo donde NO seas miembro
¿Ves botón "Solicitar Unirse"? SI / NO
```

## TEST 4: Crear equipo
```
Login como: juan.perez@alumno.com
URL: /equipos/evento/1/crear
Llena formulario:
- Nombre: "Mi Equipo Test"
- Rol: "Programador"
Click "Crear Equipo"
¿Funcionó? SI / NO
¿Qué error mostró? _______________
```

---

# 📋 DIME ESTOS RESULTADOS:

1. ¿Qué muestra la query de perfiles?
2. ¿Qué muestra la query de equipo_participante?
3. ¿Hay algún error en la consola del navegador?
4. ¿Qué pasa exactamente cuando intentas crear un equipo?
5. ¿Aparece el botón "Solicitar Unirse" en equipos ajenos?

Con esta información podré decirte exactamente qué está fallando.
