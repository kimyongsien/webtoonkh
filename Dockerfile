FROM composer:2 AS composer_deps
WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts \
    --ignore-platform-req=ext-zip

FROM node:22-alpine AS frontend_builder
WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY resources ./resources
COPY public ./public
COPY vite.config.js postcss.config.js tailwind.config.js ./
RUN npm run build

FROM php:8.4-fpm-alpine AS app
WORKDIR /var/www/html

RUN apk add --no-cache \
        bash \
        icu-dev \
        libzip-dev \
        mysql-client \
        oniguruma-dev \
        zip \
    && docker-php-ext-install \
        bcmath \
        intl \
        pdo_mysql \
        zip

RUN { \
        echo '[www]'; \
        echo 'clear_env = no'; \
    } > /usr/local/etc/php-fpm.d/zz-docker-env.conf

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .
COPY --from=composer_deps /app/vendor ./vendor
COPY --from=frontend_builder /app/public/build ./public/build

RUN cp .env.example .env \
    && composer dump-autoload --optimize --no-dev \
    && php artisan package:discover --ansi \
    && mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && ln -sfn /var/www/html/storage/app/public /var/www/html/public/storage \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R ug+rwx storage bootstrap/cache

COPY docker/app/entrypoint.sh /usr/local/bin/app-entrypoint
RUN chmod +x /usr/local/bin/app-entrypoint

ENTRYPOINT ["app-entrypoint"]
CMD ["php-fpm"]
