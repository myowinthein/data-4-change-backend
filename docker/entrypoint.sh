#!/bin/bash
set -e

cd /var/www/html

echo "==> Waiting for MySQL..."
until mysqladmin ping -h"${DB_HOST:-db}" -u"${DB_USERNAME:-data4change}" -p"${DB_PASSWORD:-secret}" --silent 2>/dev/null; do
    echo "    MySQL not ready, retrying in 2s..."
    sleep 2
done
echo "==> MySQL is ready."

echo "==> Checking vendor..."
if [ ! -f "vendor/autoload.php" ]; then
    echo "    Copying vendor from image bootstrap cache..."
    cp -r /opt/vendor_bootstrap/. vendor/
    echo "    Done."
else
    echo "    vendor/ already present."
fi

echo "==> Clearing bootstrap cache..."
rm -f bootstrap/cache/packages.php bootstrap/cache/services.php bootstrap/cache/config.php

echo "==> Checking APP_KEY..."
if grep -q "^APP_KEY=$" .env 2>/dev/null; then
    php artisan key:generate --ansi
    echo "    APP_KEY generated."
else
    echo "    APP_KEY already set."
fi

echo "==> Running migrations..."
php artisan migrate --force 2>&1 || true

echo "==> Creating storage symlink..."
php artisan storage:link 2>/dev/null || true

echo "==> Setting permissions..."
chmod -R 775 storage bootstrap/cache 2>/dev/null || true
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true

echo "==> Starting Apache..."
exec apache2-foreground
