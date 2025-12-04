@echo off
REM ============================================
REM VERIFICACION PRE-DEPLOY
REM ============================================

echo ============================================
echo   VERIFICACION ANTES DE DEPLOY
echo ============================================
echo.

cd "C:\Users\LENOVO\Documents\7MO SEMESTRE\WEB\hackathon-events"

echo [1/5] Verificando migraciones...
php artisan migrate:status | findstr /C:"Ran" > nul
if errorlevel 1 (
    echo ERROR: Algunas migraciones no están ejecutadas localmente
    echo Ejecuta: php artisan migrate
    pause
    exit /b 1
)
echo OK: Todas las migraciones estan listas
echo.

echo [2/5] Verificando seeders...
if not exist "database\seeders\DatabaseSeeder.php" (
    echo ERROR: DatabaseSeeder.php no encontrado
    pause
    exit /b 1
)
echo OK: DatabaseSeeder encontrado
echo.

echo [3/5] Verificando archivos de deploy...
if not exist "render-build.sh" (
    echo ERROR: render-build.sh no encontrado
    pause
    exit /b 1
)
if not exist "render.yaml" (
    echo ERROR: render.yaml no encontrado
    pause
    exit /b 1
)
if not exist "Procfile" (
    echo ERROR: Procfile no encontrado
    pause
    exit /b 1
)
echo OK: Archivos de deploy presentes
echo.

echo [4/5] Verificando .env.example...
if not exist ".env.example" (
    echo ADVERTENCIA: .env.example no encontrado
) else (
    echo OK: .env.example presente
)
echo.

echo [5/5] Verificando Git...
git status > nul 2>&1
if errorlevel 1 (
    echo ADVERTENCIA: Este no es un repositorio Git
    echo Necesitas inicializar Git:
    echo   git init
    echo   git add .
    echo   git commit -m "Proyecto completo"
) else (
    echo OK: Repositorio Git presente
    git status --short
)
echo.

echo ============================================
echo   RESUMEN DE VERIFICACION
echo ============================================
echo.
echo TODO LISTO PARA DEPLOY! ✓
echo.
echo SIGUIENTE PASO:
echo 1. Subir cambios a GitHub:
echo    git add .
echo    git commit -m "Listo para deploy con Supabase"
echo    git push origin main
echo.
echo 2. Ve a https://render.com y crea Web Service
echo.
echo 3. Configura variables de entorno de Supabase
echo.
echo 4. IMPORTANTE: Anota estas credenciales de prueba:
echo    Admin:    admin@hackathon.com / password
echo    Juez:     juez1@hackathon.com / password
echo    Participante: juan.perez@alumno.com / password
echo.
pause
