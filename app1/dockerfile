FROM php:8.3-fpm-alpine

# Set working directory
WORKDIR /var/www

# Install system dependencies, including PostgreSQL client development files
RUN apk update && apk add --no-cache \
    git \
    curl \
    libzip-dev \
    unzip \
    nodejs \
    npm \
    postgresql-dev \
    linux-headers

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql zip pcntl bcmath sockets

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader

# Create storage link
RUN php artisan storage:link

# Set directory permissions
RUN chown -R www-data:www-data /var/www

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start PHP-FPM server
CMD ["php-fpm"]