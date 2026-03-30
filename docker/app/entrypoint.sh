#!/bin/sh
set -e

cd /var/www/html

if [ ! -f .env ] && [ -f .env.docker.example ]; then
    cp .env.docker.example .env
fi

if [ -f .env ] && ! grep -q '^APP_KEY=base64:' .env; then
    php artisan key:generate --force
fi

# Docker env vars override .env values. Re-export APP_KEY from the generated
# file so Laravel sees the real key at runtime.
if [ -f .env ]; then
    APP_KEY_VALUE=$(grep '^APP_KEY=' .env | cut -d '=' -f 2-)
    if [ -n "$APP_KEY_VALUE" ]; then
        export APP_KEY="$APP_KEY_VALUE"
    fi
fi

php artisan storage:link --force
php artisan migrate --force

exec "$@"
