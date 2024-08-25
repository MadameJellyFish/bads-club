# Image oficiel de PHP avec FPM
FROM php:8.2-fpm

# Installe les extensions de PHP necesaires
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install \
    intl \
    pdo \
    pdo_pgsql \
    zip

# Installe Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copie los fichiers de l'app
COPY . /var/www

# Establece permisos adecuados
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Establece el directorio de trabajo
WORKDIR /var/www
