FROM php:8.2-apache

RUN a2enmod rewrite
RUN apt-get update && apt-get install -y git unzip libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Serve Laravel from /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's#/var/www/html#/var/www/html/public#g' /etc/apache2/sites-available/000-default.conf /etc/apache2/apache2.conf

RUN composer install --no-dev --optimize-autoloader
RUN php artisan key:generate --force || true && php artisan storage:link || true

CMD ["apache2-foreground"]
