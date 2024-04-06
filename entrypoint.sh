#!/bin/bash

while ! nc -z mysql 3306; do
    echo "Waiting for MySQL to be available..."
    sleep 1
done

php artisan migrate --force
php artisan db:seed --class=SearchSeeder

exec apache2-foreground
