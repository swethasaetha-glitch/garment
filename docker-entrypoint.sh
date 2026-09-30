#!/usr/bin/env bash
set -e

# Ensure database directory exists
mkdir -p database
touch database/database.sqlite
chmod -R 777 database

# Generate key if APP_KEY is empty or missing
if [ -z "$APP_KEY" ]; then
  echo "APP_KEY empty, generating new key..."
  php artisan key:generate --force
fi

# Run migrations and seed database
php artisan migrate --force
php artisan db:seed --force

# Clear and cache configurations safely
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Start web service on Render's PORT
PORT="${PORT:-10000}"
echo "Starting Laravel server on 0.0.0.0:$PORT..."
exec php artisan serve --host=0.0.0.0 --port="$PORT"
