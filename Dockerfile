FROM php:8.2-fpm

# Set the working directory in the container
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && \
    apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libpq-dev  

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql zip

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy application files to the container
COPY . .

# Copy .env.example to .env
COPY .env.example .env

# Install Laravel dependencies
RUN composer install

# Set permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Run Laravel commands
RUN php artisan key:generate
RUN php artisan jwt:secret
RUN php artisan config:clear
RUN php artisan migrate

# Expose port 8080 and start the PHP-FPM server
EXPOSE 8080
CMD ["php-fpm"]
