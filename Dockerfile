# Dockerfile
FROM php:8.1-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    mariadb-client \
    && docker-php-ext-install pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory contents
COPY . /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install app dependencies
RUN composer install

# Expose port 8000 and start php-fpm server
EXPOSE 8000
CMD ["php-fpm"]