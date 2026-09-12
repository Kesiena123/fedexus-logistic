FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libpq-dev nginx supervisor \
    && docker-php-ext-install pdo_mysql pdo_pgsql mbstring zip bcmath sockets \
    && pecl install redis && docker-php-ext-enable redis \
    && echo 'memory_limit = 256M' >> /usr/local/etc/php/conf.d/zz-container.ini \
    && echo 'upload_max_filesize = 32M' >> /usr/local/etc/php/conf.d/zz-container.ini \
    && echo 'post_max_size = 32M' >> /usr/local/etc/php/conf.d/zz-container.ini

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html/backend

COPY backend/composer.json backend/composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

COPY backend/ .

RUN mkdir -p bootstrap/cache storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs && \
    chown -R www-data:www-data bootstrap/cache storage && \
    chmod -R 775 bootstrap/cache storage && \
    touch storage/logs/laravel.log && \
    chown www-data:www-data storage/logs/laravel.log && \
    php artisan package:discover --ansi && \
    php artisan storage:link --force

COPY backend/nginx.conf /etc/nginx/sites-enabled/default
COPY backend/supervisord.conf /etc/supervisor/conf.d/laravel.conf

EXPOSE 8080

RUN chmod +x start.sh

CMD ["./start.sh"]
