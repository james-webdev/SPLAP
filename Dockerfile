# Dockerfile
FROM php:8.1-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    mariadb-client \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    && docker-php-ext-install pdo_mysql mbstring xml ctype json zip

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory contents
COPY . /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install app dependencies
RUN composer install

# Expose port and start php-fpm server
CMD php -S 0.0.0.0:${PORT:-8000} -t public