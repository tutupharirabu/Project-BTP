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

exec "$@"
