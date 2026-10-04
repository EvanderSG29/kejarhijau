#!/bin/sh
set -e

# Cache configuration on startup
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Run database migrations
php artisan migrate --force || true

# Update Nginx port dynamically if Render injects $PORT
if [ -n "$PORT" ]; then
    sed -i "s/8080/$PORT/g" /etc/nginx/nginx.conf
fi

# Start PHP-FPM in background
php-fpm -D

# Start Nginx in foreground
exec nginx -g "daemon off;"
