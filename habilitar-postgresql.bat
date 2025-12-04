@echo off
REM ============================================
REM SOLUCION: Habilitar PostgreSQL en Herd Lite
REM ============================================

echo ============================================
echo   HABILITANDO DRIVER POSTGRESQL
echo ============================================
echo.

REM Agregar el directorio bin de Herd al PATH temporalmente
echo [1/2] Configurando PATH para PostgreSQL...
set "PATH=C:\Users\LENOVO\.config\herd-lite\bin;%PATH%"
echo OK: PATH configurado
echo.

REM Verificar que PostgreSQL esté disponible
echo [2/2] Verificando drivers de PostgreSQL...
php -m | findstr /C:"pdo_pgsql" > nul
if errorlevel 1 (
    echo ERROR: El driver pdo_pgsql no está disponible
    echo.
    echo POSIBLES SOLUCIONES:
    echo 1. Reinstalar Herd Lite
    echo 2. Usar XAMPP o Laragon en su lugar
    echo 3. Instalar PHP manualmente con extensión PostgreSQL
    echo.
    pause
    exit /b 1
)

php -m | findstr /C:"pgsql" > nul
if errorlevel 1 (
    echo ADVERTENCIA: pgsql básico no disponible (solo pdo_pgsql)
) else (
    echo OK: Ambos drivers de PostgreSQL están activos
)

echo.
echo ============================================
echo   DRIVERS POSTGRESQL HABILITADOS
echo ============================================
echo.
echo Ahora puedes ejecutar migrate-to-supabase.bat
echo.
pause
