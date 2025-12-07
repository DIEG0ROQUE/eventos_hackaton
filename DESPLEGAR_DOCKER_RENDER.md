# 🚀 GUÍA: DESPLEGAR EN RENDER CON DOCKER

## 📌 TU SITUACIÓN ACTUAL

Render no muestra "PHP" en la lista de lenguajes. **Esto es NORMAL**.

Laravel se despliega mejor usando **Docker**.

---

## ✅ SOLUCIÓN: USAR DOCKER

Ya tienes todo listo:
- ✅ `Dockerfile` (recién creado)
- ✅ `render.yaml` (actualizado)

---

## 🎯 PASOS PARA DESPLEGAR

### PASO 1: Subir Archivos a GitHub

Primero, sube los nuevos archivos:

```bash
cd C:\Users\diego\Downloads\eventos_hackaton

git add Dockerfile render.yaml
git commit -m "Agregar configuración Docker para Render"
git push origin main
```

---

### PASO 2: Configurar en Render

#### A. Vuelve a la pantalla que tienes abierta

En el dropdown de **Language**, selecciona: **`Docker`**

#### B. Configuración del Web Service:

```
Name: eventos-hackathon
Environment: Docker
Region: Oregon (US West)
Branch: main
Root Directory: (dejar vacío)
```

#### C. Deploy Settings:

Render detectará automáticamente el `Dockerfile` y usará:
- **Dockerfile Path:** `./Dockerfile`
- **Docker Context:** `.`

**No necesitas cambiar nada más** ✅

---

### PASO 3: Crear Base de Datos (ANTES de Deploy)

**IMPORTANTE:** Crea la base de datos PRIMERO.

1. **En Render Dashboard**, clic: "New +" → "PostgreSQL"
2. **Configuración:**
   ```
   Name: eventos-hackathon-db
   Database: eventos_hackaton
   User: eventos_hackaton_user
   Region: Oregon (mismo que web service)
   Plan: Free
   ```
3. **Clic:** "Create Database"
4. **Espera 1-2 minutos** hasta que esté lista

---

### PASO 4: Conectar Base de Datos al Web Service

#### Opción A: Usar Blueprint (Render.yaml)

Si usas `render.yaml`, Render conectará automáticamente la DB.

1. **En vez de "New Web Service"**, usa: "New" → "Blueprint"
2. **Conecta tu repositorio**
3. **Render leerá** `render.yaml` y creará todo automáticamente

#### Opción B: Manual

1. **Vuelve a tu Web Service**
2. **Ve a:** Environment
3. **Agrega variables de DB:**
   - Copia el **Internal Database URL** de tu PostgreSQL
   - Agrégalo como `DATABASE_URL`
   
   O agrega individualmente:
   ```
   DB_HOST=[internal hostname]
   DB_PORT=5432
   DB_DATABASE=eventos_hackaton
   DB_USERNAME=eventos_hackaton_user
   DB_PASSWORD=[la que te dio Render]
   ```

---

### PASO 5: Variables de Entorno (Email)

En Environment, agrega estas variables de email:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp-relay.brevo.com
MAIL_PORT=587
MAIL_USERNAME=eventos.contacto.web@gmail.com
MAIL_PASSWORD=lxxx gyrq bgrn ubty
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=eventos.contacto.web@gmail.com
MAIL_FROM_NAME=Eventos Hackathon TecNM
```

---

### PASO 6: Iniciar Deploy

1. **Clic:** "Create Web Service" (si es manual)
   O **"Apply"** (si es Blueprint)
2. **Espera 10-15 minutos** (la primera vez tarda más)
3. **Monitorea los logs**

---

## 📊 LOGS QUE DEBERÍAS VER

Durante el deploy verás algo como:

```
==> Cloning repository...
==> Building Docker image...
Step 1/20 : FROM php:8.2-fpm
Step 2/20 : RUN apt-get update...
...
==> Successfully built Docker image
==> Starting container...
🚀 Iniciando aplicación Laravel...
Optimizing configuration...
Running migrations...
Migration table created successfully.
Migrated: 2024_01_01_000001_create_...
==> Your service is live!
```

---

## ✅ VERIFICAR QUE FUNCIONA

1. **URL de tu app:** `https://eventos-hackathon.onrender.com`
2. **Deberías ver** la página de inicio
3. **Prueba:**
   - Registrar usuario
   - Login
   - Crear evento (admin)

---

## 🐛 SOLUCIÓN DE PROBLEMAS

### Error: "Failed to build Docker image"

**Solución:**
1. Verifica que `Dockerfile` esté en la raíz del proyecto
2. Verifica que subiste el archivo a GitHub
3. Revisa los logs para ver el error específico

---

### Error: "Database connection failed"

**Solución:**
1. Verifica que creaste la base de datos PRIMERO
2. Verifica las variables `DB_*`
3. Usa el "Internal Database URL" (no el external)

---

### Error: "Application Error"

**Solución:**
1. Genera APP_KEY:
   - Ve a Shell en Render
   - Ejecuta: `php artisan key:generate --show`
   - Copia la key
   - Agrégala como variable: `APP_KEY=base64:...`
2. Limpia caché:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

---

### La app tarda mucho en cargar (primera vez)

**Esto es NORMAL** en el plan gratuito:
- Primera carga: 30-60 segundos
- Después de 15 min sin uso, se "duerme"
- Al despertar: otros 30 segundos

**Solución para producción:**
- Upgrade a plan Starter ($7/mes)
- La app nunca se duerme

---

## 🎯 OPCIÓN ALTERNATIVA: USAR BLUEPRINT

### Método más fácil (RECOMENDADO)

En lugar de crear Web Service manualmente:

1. **En Render Dashboard:** New → **Blueprint**
2. **Conecta tu repositorio:** `eventos_hackaton`
3. **Render detectará** `render.yaml`
4. **Clic:** "Apply"
5. **Render creará automáticamente:**
   - PostgreSQL database
   - Web Service
   - Todas las variables de entorno
   - Conexión entre ambos

**¡TODO AUTOMÁTICO!** 🎉

---

## 📝 RESUMEN

### LO QUE TIENES AHORA:
- ✅ Dockerfile optimizado para Laravel
- ✅ render.yaml con toda la configuración
- ✅ Listo para desplegar con Docker

### OPCIONES PARA DESPLEGAR:

**OPCIÓN A - Blueprint (Más fácil):**
1. Sube archivos a GitHub
2. New → Blueprint en Render
3. Apply
4. ¡Listo! (10 min)

**OPCIÓN B - Manual:**
1. Crear PostgreSQL database
2. New Web Service (Docker)
3. Configurar variables
4. Deploy (15 min)

---

## 🚀 SIGUIENTE PASO

¿Qué prefieres?

**A)** Usar Blueprint (automático, más fácil)
**B)** Crear manualmente (más control)
**C)** Necesito ayuda con GitHub primero

¡Dime y te guío! 🎯
