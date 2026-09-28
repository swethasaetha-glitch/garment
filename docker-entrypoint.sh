#!/usr/bin/env bash
set -e

# Ensure SQLite database directory & database file exist
mkdir -p database
touch database/database.sqlite
chmod -R 777 database

# Run database migrations
php artisan migrate --force

# Cache configuration, routes, and views
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Laravel server on Render's dynamic PORT
PORT="${PORT:-10000}"
echo "Starting Laravel Garment ERP on 0.0.0.0:$PORT..."
exec php artisan serve --host=0.0.0.0 --port="$PORT"
