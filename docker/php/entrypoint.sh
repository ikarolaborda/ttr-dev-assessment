#!/bin/bash

php artisan config:cache
php artisan route:cache

exec docker-php-entrypoint php-fpm
