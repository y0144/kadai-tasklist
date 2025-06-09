#!/usr/bin/env bash
echo "Running composer"
composer config -g repos.packagist composer
composer install --no-dev --working-dir=/var/www/html

echo "Running migrations..."
php artisan migrate --force

echo "Running vite..."
npm install
npm run build