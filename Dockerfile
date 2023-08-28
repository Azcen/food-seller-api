FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy composer files and install dependencies
COPY app/composer.json app/composer.lock /var/www/html/
RUN composer install --no-dev --no-scripts --no-suggest --optimize-autoloader

# Copy application code
COPY . .

# Generate the application key
RUN php artisan key:generate

# Generate JWT secret
RUN php artisan jwt:secret

# Migrate the database
RUN php artisan migrate

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]