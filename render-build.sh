#!/usr/bin/env bash
set -o errexit

# Verificar que PHP esté disponible
if ! command -v php &> /dev/null; then
    echo "ERROR: PHP is not available. Please set Environment to 'PHP' in Render settings."
    echo "Go to Settings -> Build & Deploy -> Environment -> Select 'PHP'"
    exit 1
fi

# Verificar que Composer esté disponible
if ! command -v composer &> /dev/null; then
    echo "ERROR: Composer is not available. Please set Environment to 'PHP' in Render settings."
    exit 1
fi

echo "==> PHP version: $(php -v | head -n 1)"
echo "==> Composer version: $(composer --version)"

# Instalar dependencias de Composer
composer install --no-dev --optimize-autoloader --no-interaction

# Instalar dependencias de Node
npm ci --prefer-offline --no-audit

# Compilar assets
npm run build

# Limpiar cache
php artisan config:clear
php artisan cache:clear  
php artisan view:clear

# Optimizar para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ejecutar migraciones y seeders
php artisan migrate --force
php artisan db:seed --force
