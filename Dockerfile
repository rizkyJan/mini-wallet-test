FROM node:22-alpine AS node_builder

WORKDIR /app

COPY package*.json vite.config.* ./
COPY resources ./resources
COPY public ./public

RUN npm ci
RUN npm run build


FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo_mysql zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

COPY --from=node_builder /app/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY docker/start.sh /usr/local/bin/start.sh

RUN chmod +x /usr/local/bin/start.sh \
    && chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8000

CMD ["start.sh"]