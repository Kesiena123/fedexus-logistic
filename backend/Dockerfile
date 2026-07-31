FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev nginx supervisor \
    && docker-php-ext-install pdo_mysql mbstring zip bcmath sockets \
    && pecl install redis && docker-php-ext-enable redis

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html/backend

COPY backend/composer.json backend/composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

COPY backend/ .

RUN php artisan storage:link --force

COPY backend/nginx.conf /etc/nginx/sites-enabled/default
COPY backend/supervisord.conf /etc/supervisor/conf.d/laravel.conf

EXPOSE 8080

RUN chmod +x start.sh

CMD ["./start.sh"]
