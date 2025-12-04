#!/bin/bash
# ============================================
# Script para Migrar a Supabase PostgreSQL
# ============================================

echo "🚀 Iniciando migración a Supabase..."

# Paso 1: Respaldar .env actual
echo "📦 Respaldando configuración actual..."
cp .env .env.mysql.backup

# Paso 2: Copiar configuración de Supabase
echo "🔄 Configurando conexión a Supabase..."
cp .env.supabase .env

# Paso 3: Limpiar cache de configuración
echo "🧹 Limpiando cache..."
php artisan config:clear
php artisan cache:clear

# Paso 4: Verificar conexión
echo "🔍 Verificando conexión a Supabase..."
php artisan db:show || { echo "❌ Error: No se pudo conectar a Supabase"; exit 1; }

# Paso 5: Ejecutar migraciones
echo "📊 Ejecutando migraciones..."
php artisan migrate:fresh --force

# Paso 6: Ejecutar seeders
echo "🌱 Ejecutando seeders..."
php artisan db:seed --force

echo "✅ ¡Migración completada exitosamente!"
echo "📝 Tu configuración MySQL fue respaldada en .env.mysql.backup"
