#!/bin/sh
set -e

PORT="${PORT:-8000}"

sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/g" /etc/apache2/sites-available/000-default.conf

php artisan storage:link || true
php artisan migrate --force
php artisan db:seed --force
php artisan config:cache
php artisan view:cache

apache2-foreground