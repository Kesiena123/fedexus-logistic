#!/bin/bash
set -e

php artisan migrate --force
php artisan storage:link --force

sed -i "s/listen 8080;/listen ${PORT:-8080};/" /etc/nginx/sites-enabled/default

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/laravel.conf