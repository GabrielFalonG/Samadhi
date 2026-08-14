#!/bin/sh
set -e

echo "=== Iniciando contenedor de producción ==="

# ============================================================
# 1. Configuración desde variables de entorno
# ============================================================

LARAVEL_ENV="/var/www/html/.env"

echo "=== Configuración mediante variables de entorno ==="

if [ -z "${APP_KEY:-}" ]; then
    echo "ERROR: APP_KEY no está definida."
    echo "Variables APP_* disponibles:"
    env | grep '^APP_' | sed 's/APP_KEY=.*/APP_KEY=***OCULTA***/'
    exit 1
fi

echo "APP_KEY recibida correctamente."

# Crear .env para Laravel
touch "$LARAVEL_ENV"

cat > "$LARAVEL_ENV" <<EOF
APP_NAME="${APP_NAME:-Samadhi}"
APP_ENV="${APP_ENV:-production}"
APP_KEY="${APP_KEY}"
APP_DEBUG="${APP_DEBUG:-false}"
APP_URL="${APP_URL:-}"

LOG_CHANNEL="${LOG_CHANNEL:-stack}"
LOG_LEVEL="${LOG_LEVEL:-error}"

DB_CONNECTION="${DB_CONNECTION:-mysql}"
DB_HOST="${DB_HOST:-}"
DB_PORT="${DB_PORT:-3306}"
DB_DATABASE="${DB_DATABASE:-}"
DB_USERNAME="${DB_USERNAME:-}"
DB_PASSWORD="${DB_PASSWORD:-}"

CACHE_STORE="${CACHE_STORE:-file}"
SESSION_DRIVER="${SESSION_DRIVER:-file}"
QUEUE_CONNECTION="${QUEUE_CONNECTION:-sync}"

REDIS_HOST="${REDIS_HOST:-}"
REDIS_PASSWORD="${REDIS_PASSWORD:-}"
REDIS_PORT="${REDIS_PORT:-6379}"
EOF

echo "=== Configuración Laravel ==="
echo "APP_ENV=$APP_ENV"
echo "DB_HOST=$DB_HOST"
echo "DB_DATABASE=$DB_DATABASE"
echo "QUEUE_CONNECTION=$QUEUE_CONNECTION"
echo "CACHE_STORE=$CACHE_STORE"
echo "SESSION_DRIVER=$SESSION_DRIVER"
echo "REDIS_HOST=$REDIS_HOST"
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
# 6. Storage
# ============================================================

echo "Configurando storage..."

php artisan storage:link


# ============================================================
# 7. Migraciones
# ============================================================

echo "Ejecutando migraciones..."

php artisan migrate --seed --force


# ============================================================
# 8. Supervisor
# ============================================================

echo "Iniciando Supervisor..."

exec /usr/bin/supervisord -n \
    -c /etc/supervisor/conf.d/supervisord.conf
