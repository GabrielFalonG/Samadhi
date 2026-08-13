#!/bin/sh
set -e

echo "=== Iniciando contenedor de producción ==="

# ============================================================
# 1. Copiar configuración PROD a .env de Laravel
# ============================================================

ENV_FILE="/var/www/.env.prod"
LARAVEL_ENV="/var/www/html/.env"

if [ -f "$ENV_FILE" ]; then
    echo "=== Encontrado $ENV_FILE ==="
    echo "=== Copiando configuración a $LARAVEL_ENV ==="

    cp "$ENV_FILE" "$LARAVEL_ENV"
else
    echo "=== No se encontró $ENV_FILE ==="
    echo "=== Usando variables de entorno proporcionadas por Railway ==="

    touch "$LARAVEL_ENV"
fi

echo "Archivo de producción encontrado: $ENV_FILE"

echo "Copiando configuración de producción a .env..."

cp "$ENV_FILE" "$LARAVEL_ENV"

echo "Configuración de producción copiada correctamente."


# ============================================================
# 2. Verificar APP_KEY
# ============================================================

CURRENT_KEY=$(grep "^APP_KEY=" "$ENV_FILE" | cut -d '=' -f2-)

if [ -z "$CURRENT_KEY" ]; then

    echo "APP_KEY está vacía. Generando nueva clave..."

    NEW_KEY=$(php artisan key:generate --show)

    sed "s|^APP_KEY=.*|APP_KEY=$NEW_KEY|" \
        "$ENV_FILE" > /tmp/env.tmp

    cat /tmp/env.tmp > "$ENV_FILE"

    rm -f /tmp/env.tmp

    # Copiar nuevamente porque .env.prod acaba de cambiar
    cp "$ENV_FILE" "$LARAVEL_ENV"

    export APP_KEY="$NEW_KEY"

    echo "APP_KEY generada correctamente."

else

    export APP_KEY="$CURRENT_KEY"

    echo "APP_KEY existente encontrada y cargada."

fi


if [ -z "$APP_KEY" ]; then
    echo "ERROR: APP_KEY continúa vacía."
    exit 1
fi

echo "APP_KEY disponible correctamente."


# ============================================================
# 3. Verificar configuración cargada
# ============================================================

echo "=== Configuración Laravel ==="

echo "APP_ENV=$(grep '^APP_ENV=' "$LARAVEL_ENV" | cut -d '=' -f2-)"
echo "DB_HOST=$(grep '^DB_HOST=' "$LARAVEL_ENV" | cut -d '=' -f2-)"
echo "DB_DATABASE=$(grep '^DB_DATABASE=' "$LARAVEL_ENV" | cut -d '=' -f2-)"
echo "QUEUE_CONNECTION=$(grep '^QUEUE_CONNECTION=' "$LARAVEL_ENV" | cut -d '=' -f2-)"
echo "CACHE_STORE=$(grep '^CACHE_STORE=' "$LARAVEL_ENV" | cut -d '=' -f2-)"
echo "SESSION_DRIVER=$(grep '^SESSION_DRIVER=' "$LARAVEL_ENV" | cut -d '=' -f2-)"
echo "REDIS_HOST=$(grep '^REDIS_HOST=' "$LARAVEL_ENV" | cut -d '=' -f2-)"

echo "================================"


# ============================================================
# 4. Esperar Base de Datos
# ============================================================

if [ -n "$DB_HOST" ]; then

    echo "Esperando conexión a la base de datos en $DB_HOST:${DB_PORT:-3306}..."

    max_tries=30
    count=0

    while ! php -r "
        \$s = @fsockopen(
            getenv('DB_HOST'),
            getenv('DB_PORT') ?: 3306
        );

        if (\$s) {
            fclose(\$s);
            exit(0);
        }

        exit(1);
    " > /dev/null 2>&1; do

        count=$((count+1))

        if [ "$count" -ge "$max_tries" ]; then
            echo "ERROR: La base de datos no respondió tras $max_tries segundos."
            exit 1
        fi

        sleep 1
    done

    echo "¡Conexión a la base de datos establecida!"

fi


# ============================================================
# 5. Cachés
# ============================================================

echo "Optimizando configuraciones y cachés..."

php artisan optimize:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache


# ============================================================
# 6. Migraciones
# ============================================================

echo "Ejecutando migraciones..."

php artisan migrate --seed --force


# ============================================================
# 7. Supervisor
# ============================================================

echo "Iniciando Supervisor..."

exec /usr/bin/supervisord -n \
    -c /etc/supervisor/conf.d/supervisord.conf
