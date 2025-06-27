#!/bin/bash

# Destination of env file inside container
ENV_FILE="/var/www/.env"

# === [DEV ONLY: TIDAK DIPERLUKAN DI PROD] ===
# Loop through XDEBUG, PHP_IDE_CONFIG and REMOTE_HOST variables and check if they are set.
# These are used for local debugging/PHPStorm.
# for VAR in XDEBUG PHP_IDE_CONFIG REMOTE_HOST
# do
#   if [ -z "${!VAR}" ] && [ -f "${ENV_FILE}" ]; then
#     VALUE=$(grep $VAR $ENV_FILE | cut -d '=' -f 2-)
#     if [ ! -z "${VALUE}" ]; then
#       sed -i "/$VAR/d"  ~/.bashrc
#       echo "export $VAR=$VALUE" >> ~/.bashrc;
#     fi
#   fi
# done

# Set default REMOTE_HOST for dev on Windows/Mac
# if [ -z "${REMOTE_HOST}" ]; then
#   REMOTE_HOST="host.docker.internal"
#   sed -i "/REMOTE_HOST/d"  ~/.bashrc
#   echo "export REMOTE_HOST=\"$REMOTE_HOST\"" >> ~/.bashrc;
# fi

# Source the .bashrc file so that the exported variables are available.
# . ~/.bashrc
# === [END DEV ONLY] ===

# === [DEV ONLY: TIDAK DIPERLUKAN DI PROD] ===
# Start the cron service (optional in prod; handled differently or via host-level cron in prod environments)
# service cron start
# === [END DEV ONLY] ===

#####################################
# NPM Build Process:
#####################################
if [ -f "/var/www/package.json" ]; then
  echo "Checking Node.js dependencies..."
  cd /var/www
  
  # Check if node_modules exists or if package-lock.json is newer than node_modules
  if [ ! -d "node_modules" ] || [ "package-lock.json" -nt "node_modules" ]; then
    echo "Installing/updating npm dependencies..."
    npm ci || npm install
  fi
  
  # Check if we need to build assets
  BUILD_NEEDED=false
  
  if [ ! -d "public/build" ] || [ ! -f "public/build/manifest.json" ]; then
    BUILD_NEEDED=true
    echo "Build folder or manifest not found, build needed..."
  else
    if [ -n "$(find resources/js resources/css -newer public/build/manifest.json -print -quit 2>/dev/null)" ]; then
      BUILD_NEEDED=true
      echo "Source files changed, rebuild needed..."
    fi
  fi
  
  # Hanya build asset untuk prod jika butuh
  # if [ "$BUILD_NEEDED" = true ] && [ "$APP_ENV" != "local" ]; then
  #   echo "Building production assets..."
  #   npm run build
  # === [DEV ONLY: TIDAK DIPERLUKAN DI PROD] ===
  # elif [ "$BUILD_NEEDED" = true ] && [ "$APP_ENV" = "local" ]; then
  #   echo "Development environment detected. Run 'docker-compose exec php-fpm npm run dev' for hot reloading."
  #   if [ ! -f "public/build/manifest.json" ]; then
  #     mkdir -p public/build
  #     echo '{}' > public/build/manifest.json
  #     echo "Created empty manifest.json to prevent errors."
  #   fi
  # fi
  # === [END DEV ONLY] ===

  # cd - > /dev/null
fi

# === [DEV ONLY: TIDAK DIPERLUKAN DI PROD] ===
# Toggle xdebug - only for local development, never enable in production!
# if [ "true" == "$XDEBUG" ] && [ ! -f /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini ]; then
#   sed -i '/PHP_IDE_CONFIG/d' /etc/cron.d/laravel-scheduler
#   if [ ! -z "${PHP_IDE_CONFIG}" ]; then
#     echo -e "PHP_IDE_CONFIG=\"$PHP_IDE_CONFIG\"\n$(cat /etc/cron.d/laravel-scheduler)" > /etc/cron.d/laravel-scheduler
#   fi
#   docker-php-ext-enable xdebug && \
#   echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
#   echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
#   echo "xdebug.discover_client_host=false" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
#   echo "xdebug.client_host=$REMOTE_HOST" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini;

# elif [ -f /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini ]; then
#   sed -i '/PHP_IDE_CONFIG/d' /etc/cron.d/laravel-scheduler
#   rm -rf /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
# fi
# === [END DEV ONLY] ===

# Start main process
exec "$@"