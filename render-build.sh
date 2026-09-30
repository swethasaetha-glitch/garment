#!/usr/bin/env bash
# Exit on error
set -o errexit

# Install PHP composer dependencies
composer install --no-dev --optimize-autoloader

# Install Node dependencies and build assets
npm install
npm run build

# Ensure SQLite database exists
mkdir -p database
touch database/database.sqlite

# Run migrations, seed initial data, and cache config/routes
php artisan migrate --force
php artisan db:seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
