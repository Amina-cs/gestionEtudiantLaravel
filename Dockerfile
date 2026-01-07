FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev zip libzip-dev unzip git curl

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql zip gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Permissions for Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
EXPOSE 9000
CMD ["php-fpm"]