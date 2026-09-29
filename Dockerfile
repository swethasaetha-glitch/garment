FROM php:8.2-cli

# Install system dependencies, PHP extensions (SQLite, MySQL, PostgreSQL), and Node.js
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libsqlite3-dev \
    libpq-dev \
    libzip-dev \
    zip \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_sqlite pdo_mysql pdo_pgsql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy repository content
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node dependencies and build assets
RUN npm install && npm run build

# Set directory permissions for Laravel
RUN chmod -R 777 storage bootstrap/cache

# Entrypoint script execution
RUN chmod +x docker-entrypoint.sh

ENTRYPOINT ["./docker-entrypoint.sh"]
