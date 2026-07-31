#!/bin/bash
php artisan migrate --force
php artisan storage:link --force
sed -i "s/8080/$PORT/g" /etc/nginx/sites-enabled/default
/usr/bin/supervisord -c /etc/supervisor/conf.d/laravel.conf
