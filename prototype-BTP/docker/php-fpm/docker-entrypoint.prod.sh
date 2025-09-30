#!/bin/bash
set -e

# Optionally run Composer install if requested
if [ "${RUN_COMPOSER_INSTALL:-false}" = "true" ] && [ -f /var/www/app/composer.json ]; then
  echo "Running composer install --no-dev --optimize-autoloader"
  composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist
fi

# Optionally build assets if requested (assumes npm dependencies already available)
if [ "${BUILD_ASSETS:-false}" = "true" ] && [ -f /var/www/app/package.json ]; then
  echo "Building frontend assets"
  cd /var/www/app
  npm ci --omit=dev
  npm run build
fi

if [ -d "/var/www/app/storage" ]; then
  echo "Ensuring write permissions for storage and bootstrap/cache"
  chown -R www-data:www-data /var/www/app/storage /var/www/app/bootstrap/cache 2>/dev/null || true
  chmod -R ug+rwX /var/www/app/storage /var/www/app/bootstrap/cache 2>/dev/null || true
fi

exec "$@"
