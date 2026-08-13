#!/bin/sh
set -e

echo "=== Iniciando contenedor de producción ==="

# ============================================================
# 1. Configuración de entorno
# ============================================================

ENV_FILE="/var/www/.env.prod"
LARAVEL_ENV="/var/www/html/.env"

if [ -f "$ENV_FILE" ]; then

    echo "=== Encontrado $ENV_FILE ==="
    echo "=== Usando configuración PROD local ==="

    cp "$ENV_FILE" "$LARAVEL_ENV"

    # Exportar las variables del .env para que estén disponibles
    # para los comandos ejecutados por este script.
    set -a
    . "$LARAVEL_ENV"
    set +a

else

    echo "=== No se encontró $ENV_FILE ==="
    echo "=== Usando variables de entorno proporcionadas por Railway ==="

    # Railway proporciona las variables directamente al contenedor.
    # Laravel puede leerlas desde el entorno del proceso.
    touch "$LARAVEL_ENV"

fi


# ============================================================
# 2. Verificar APP_KEY
# ============================================================

if [ -n "${APP_KEY:-}" ]; then

    echo "APP_KEY existente encontrada y cargada."

else

    # Si estamos en PROD local y existe .env.prod,
    # podemos generar una APP_KEY si está vacía.
    if [ -f "$ENV_FILE" ]; then

        echo "APP_KEY está vacía. Generando nueva clave..."

        NEW_KEY=$(php artisan key:generate --show)

        sed "s|^APP_KEY=.*|APP_KEY=$NEW_KEY|" \
            "$LARAVEL_ENV" > /tmp/env.tmp

        cat /tmp/env.tmp > "$LARAVEL_ENV"

        rm -f /tmp/env.tmp

        export APP_KEY="$NEW_KEY"

        echo "APP_KEY generada correctamente."

    else

        echo "ERROR: APP_KEY no está definida."
        echo "Configurá APP_KEY en las variables de Railway."
        exit 1

    fi

fi


if [ -z "${APP_KEY:-}" ]; then
    echo "ERROR: APP_KEY continúa vacía."
    exit 1
fi

echo "APP_KEY disponible correctamente."


# ============================================================
# 3. Verificar configuración cargada
# ============================================================

echo "=== Configuración Laravel ==="

echo "APP_ENV=${APP_ENV:-}"
echo "DB_HOST=${DB_HOST:-}"
echo "DB_DATABASE=${DB_DATABASE:-}"
echo "QUEUE_CONNECTION=${QUEUE_CONNECTION:-}"
echo "CACHE_STORE=${CACHE_STORE:-}"
echo "SESSION_DRIVER=${SESSION_DRIVER:-}"
echo "REDIS_HOST=${REDIS_HOST:-}"

echo "================================"


# ============================================================
# 4. Esperar Base de Datos
# ============================================================

if [ -n "${DB_HOST:-}" ]; then

    echo "Esperando conexión a la base de datos en ${DB_HOST}:${DB_PORT:-3306}..."

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

else

    echo "ADVERTENCIA: DB_HOST no está definido."

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
