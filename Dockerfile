# Use the official PHP image with FPM support
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    libzip-dev \
    zip \
    libxml2-dev \
    cron \
    && docker-php-ext-install pdo pdo_mysql zip simplexml

# Install Composer (PHP dependency manager)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory inside the container
WORKDIR /var/www

# Copy all files from the local machine to the container
COPY . .

# Install Laravel dependencies using Composer
RUN composer install --no-dev --optimize-autoloader

# Set appropriate permissions for the storage and cache directories
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Generate the application key
RUN php artisan key:generate

# Copy the cron job configuration into the container
COPY ./cron/laravel-cron /etc/cron.d/laravel-cron

# Give the cron job file the appropriate permissions
RUN chmod 0644 /etc/cron.d/laravel-cron

# Apply the cron job configuration
RUN crontab /etc/cron.d/laravel-cron

# Create log file for cron logs
RUN touch /var/log/cron.log

# Set the command to run when the container starts
CMD cron && php-fpm
