# Image oficiel de PHP avec FPM
FROM php:8.2-fpm

# Installe les extensions de PHP necesaires
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    unzip \
    iputils-ping \
    && docker-php-ext-install \
    intl \
    pdo \
    pdo_pgsql \
    zip

# Installe Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copie los fichiers de l'app
COPY . /var/www

RUN ls -la /var/www

# Etablie les permisions
RUN chown -R www-data:www-data /var/www \
&& chmod -R 755 /var/www

# Etablie l'ubication du travail
WORKDIR /var/www

# # Installe dependencies de Composer, inclu PHPUnit
# RUN composer install

# # Verification que PHPUnit est installé
# RUN ./vendor/bin/phpunit --version