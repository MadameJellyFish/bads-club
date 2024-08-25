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
RUN chown -R www-data:www-data /var/www \
&& chmod -R 755 /var/www

# Establie l'ubication du travail
WORKDIR /var/www

# Installe dependencies de Composer, inclu PHPUnit
RUN composer install --dev

# Verification que PHPUnit est installé
RUN ./vendor/bin/phpunit --version