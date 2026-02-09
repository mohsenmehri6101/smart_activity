# Base image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl libonig-dev libxml2-dev \
    zip npm mariadb-client && \
    docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath xml

# Copy composer and install
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Build frontend if exists
WORKDIR /var/www/html/frontend
RUN npm install && npm run build

WORKDIR /var/www/html

# Copy database
COPY database/database.sql /docker-entrypoint-initdb.d/

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 9000
CMD ["php-fpm"]
