FROM php:8.2-fpm

# Definir el nuevo directorio de trabajo
WORKDIR /var/www/html

# Instalar dependencias del sistema requeridas para Laravel y Maatwebsite Excel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    supervisor \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Configurar e instalar extensiones de PHP necesarias (GD y ZIP son obligatorias para Excel)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# --- NUEVO: Instalar y habilitar la extensión oficial de Redis vía PECL ---
RUN pecl install redis \
    && docker-php-ext-enable redis

# Instalar Composer globalmente desde la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar los archivos de tu proyecto al nuevo directorio
COPY . /var/www/html

# Copiar la configuración personalizada de Supervisor
RUN mkdir -p /var/log/supervisor
COPY ./docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Ajustar permisos para storage y bootstrap/cache sin usar sudo
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Exponer el puerto de PHP-FPM
EXPOSE 9000

# Iniciar Supervisor en primer plano para gestionar los procesos
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
