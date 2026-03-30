#!/bin/sh
set -e

cd /var/www/html

if [ ! -f .env ] && [ -f .env.example ]; then
    cp .env.example .env
fi

if [ -n "${APP_KEY:-}" ]; then
    php artisan config:clear >/dev/null 2>&1 || true
else
    if ! grep -q '^APP_KEY=base64:' .env; then
        php artisan key:generate --force
    fi

    APP_KEY_VALUE=$(grep '^APP_KEY=' .env | cut -d '=' -f 2-)
    if [ -n "$APP_KEY_VALUE" ]; then
        export APP_KEY="$APP_KEY_VALUE"
    fi
fi

php artisan storage:link --force
php artisan migrate --force
php artisan config:clear

exec "$@"
