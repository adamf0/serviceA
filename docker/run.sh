#!/bin/sh

# php artisan migrate:fresh --seed
php artisan cache:clear
php artisan route:cache
php artisan optimize:clear

/usr/bin/supervisord -c /etc/supervisord.conf