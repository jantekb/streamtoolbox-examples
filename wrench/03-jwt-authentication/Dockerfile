# 1) Composer stage
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock* ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader

# 2) PHP runtime
FROM php:8.2-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy composer files
COPY composer.json /var/www/html/

# Install dependencies
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader

# Copy application files (after composer install to preserve vendor directory)
COPY www/ /var/www/html/