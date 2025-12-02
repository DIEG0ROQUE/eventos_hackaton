@echo off
echo ====================================
echo PROBANDO MEJORAS DE CONSTANCIAS
echo ====================================
echo.

cd "C:\Users\LENOVO\Documents\7MO SEMESTRE\WEB\hackathon-events"

echo [1/3] Verificando migracion...
php artisan migrate:status | findstr "2025_12_02_100000"

echo.
echo [2/3] Limpiando cache...
php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo.
echo [3/3] Verificando rutas...
php artisan route:list | findstr "constancias"

echo.
echo ====================================
echo PRUEBAS COMPLETADAS
echo ====================================
echo.
echo Ahora puedes:
echo 1. Iniciar el servidor: php artisan serve
echo 2. Ir a: http://localhost:8000/admin/constancias/generar-nuevas
echo 3. Probar las 3 pestanas:
echo    - Constancia Individual (formulario simplificado)
echo    - Generar en Lote (con filtro por equipo)
echo    - Ganadores Automatico (NUEVO)
echo.
pause
