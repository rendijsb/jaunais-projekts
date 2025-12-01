#!/bin/bash
set -e

echo "Starting application..."

# Wait for MySQL
echo "Waiting for MySQL..."
until mysqladmin ping -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" --skip-ssl --silent 2>/dev/null; do
    sleep 2
done
echo "MySQL is ready!"

# Generate app key if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:" ]; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Start Laravel dev server and Vite
echo "Starting dev servers..."
php artisan serve --host=0.0.0.0 --port=8000 &
npm run dev -- --host 0.0.0.0 &
wait