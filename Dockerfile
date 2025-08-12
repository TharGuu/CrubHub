# --- 1) Build Vite assets ---
FROM node:18-alpine AS assets
WORKDIR /app
# Only copy what's needed for a fast, cacheable build
COPY package*.json vite.config.js ./
COPY resources ./resources
RUN npm ci && npm run build          # outputs to /app/public/build

# --- 2) PHP + Apache ---
FROM php:8.2-apache

# Enable rewrite + PHP extensions
RUN a2enmod rewrite
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev \
 && docker-php-ext-install pdo pdo_mysql zip gd

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# App files
WORKDIR /var/www/html
COPY . .

# Copy built assets from Node stage
COPY --from=assets /app/public/build ./public/build

# Serve Laravel from /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's#/var/www/html#/var/www/html/public#g' \
    /etc/apache2/sites-available/000-default.conf /etc/apache2/apache2.conf

# PHP deps and Laravel setup
RUN composer install --no-dev --optimize-autoloader
RUN php artisan key:generate --force || true \
 && php artisan storage:link || true \
 && php artisan config:clear || true

CMD ["apache2-foreground"]
