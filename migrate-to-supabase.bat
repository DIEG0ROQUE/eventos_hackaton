@echo off
REM ============================================
REM Script para Migrar a Supabase PostgreSQL
REM ============================================

REM IMPORTANTE: Agregar Herd al PATH para que encuentre libpq.dll
set "PATH=C:\Users\LENOVO\.config\herd-lite\bin;%PATH%"

echo ============================================
echo   MIGRACION A SUPABASE POSTGRESQL
echo ============================================
echo.

REM Paso 1: Respaldar .env actual
echo [1/6] Respaldando configuracion actual...
copy .env .env.mysql.backup > nul
if errorlevel 1 (
    echo ERROR: No se pudo respaldar .env
    pause
    exit /b 1
)
echo OK: Respaldo creado en .env.mysql.backup
echo.

REM Paso 2: Copiar configuración de Supabase
echo [2/6] Configurando conexion a Supabase...
copy .env.supabase .env > nul
if errorlevel 1 (
    echo ERROR: No se pudo copiar .env.supabase
    pause
    exit /b 1
)
echo OK: Configuracion de Supabase aplicada
echo.

REM Paso 3: Limpiar cache
echo [3/6] Limpiando cache de Laravel...
php artisan config:clear
php artisan cache:clear
echo OK: Cache limpiado
echo.

REM Paso 4: Verificar conexión
echo [4/6] Verificando conexion a Supabase...
php artisan tinker --execute="echo 'Conexion: ' . DB::connection()->getDatabaseName();"
if errorlevel 1 (
    echo ERROR: No se pudo conectar a Supabase
    echo Verifica tus credenciales en .env
    pause
    exit /b 1
)
echo OK: Conexion establecida
echo.

REM Paso 5: Ejecutar migraciones
echo [5/6] Ejecutando migraciones...
echo ADVERTENCIA: Esto eliminara todos los datos existentes en Supabase
set /p confirm="Continuar? (S/N): "
if /i not "%confirm%"=="S" (
    echo Operacion cancelada
    pause
    exit /b 0
)

php artisan migrate:fresh --force
if errorlevel 1 (
    echo ERROR: Fallo al ejecutar migraciones
    pause
    exit /b 1
)
echo OK: Migraciones ejecutadas
echo.

REM Paso 6: Ejecutar seeders
echo [6/6] Ejecutando seeders...
php artisan db:seed --force
if errorlevel 1 (
    echo ERROR: Fallo al ejecutar seeders
    pause
    exit /b 1
)
echo OK: Seeders ejecutados
echo.

echo ============================================
echo   MIGRACION COMPLETADA EXITOSAMENTE
echo ============================================
echo.
echo Tu base de datos MySQL local sigue intacta
echo Backup de configuracion: .env.mysql.backup
echo.
echo Para volver a MySQL local ejecuta:
echo   copy .env.mysql.backup .env
echo   php artisan config:clear
echo.
pause
