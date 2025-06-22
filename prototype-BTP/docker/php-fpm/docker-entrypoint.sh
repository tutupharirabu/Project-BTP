#!/bin/bash

# Destination of env file inside container
ENV_FILE="/var/www/.env"

# Loop through XDEBUG, PHP_IDE_CONFIG and REMOTE_HOST variables and check if they are set.
# If they are not set then check if we have values for them in the env file, if the env file exists. If we have values
# in the env file then add exports for these in in the ~./bashrc file.
for VAR in XDEBUG PHP_IDE_CONFIG REMOTE_HOST
do
  if [ -z "${!VAR}" ] && [ -f "${ENV_FILE}" ]; then
    VALUE=$(grep $VAR $ENV_FILE | cut -d '=' -f 2-)
    if [ ! -z "${VALUE}" ]; then
      # Before adding the export we clear the value, if set, to prevent duplication.
      sed -i "/$VAR/d"  ~/.bashrc
      echo "export $VAR=$VALUE" >> ~/.bashrc;
    fi
  fi
done

# If there is still no value for the REMOTE_HOST variable then we set it to the default of host.docker.internal. This
# value will be sufficient for windows and mac environments.
if [ -z "${REMOTE_HOST}" ]; then
  REMOTE_HOST="host.docker.internal"
  sed -i "/REMOTE_HOST/d"  ~/.bashrc
  echo "export REMOTE_HOST=\"$REMOTE_HOST\"" >> ~/.bashrc;
fi

# Source the .bashrc file so that the exported variables are available.
. ~/.bashrc

# Start the cron service.
service cron start

#####################################
# NPM Build Process:
#####################################
# Check if we're in the main Laravel directory
if [ -f "/var/www/package.json" ]; then
  echo "Checking Node.js dependencies..."
  cd /var/www
  
  # Check if node_modules exists or if package-lock.json is newer than node_modules
  if [ ! -d "node_modules" ] || [ "package-lock.json" -nt "node_modules" ]; then
    echo "Installing/updating npm dependencies..."
    npm ci || npm install
  fi
  
  # Check if we need to build assets
  # Build if: no build folder exists, or if source files are newer than build
  BUILD_NEEDED=false
  
  if [ ! -d "public/build" ] || [ ! -f "public/build/manifest.json" ]; then
    BUILD_NEEDED=true
    echo "Build folder or manifest not found, build needed..."
  else
    # Check if any source file is newer than the manifest
    if [ -n "$(find resources/js resources/css -newer public/build/manifest.json -print -quit 2>/dev/null)" ]; then
      BUILD_NEEDED=true
      echo "Source files changed, rebuild needed..."
    fi
  fi
  
  # Only build in production mode, for dev use npm run dev manually
  if [ "$BUILD_NEEDED" = true ] && [ "$APP_ENV" != "local" ]; then
    echo "Building production assets..."
    npm run build
  elif [ "$BUILD_NEEDED" = true ] && [ "$APP_ENV" = "local" ]; then
    echo "Development environment detected. Run 'docker-compose exec php-fpm npm run dev' for hot reloading."
    # Optionally create a basic manifest to prevent errors
    if [ ! -f "public/build/manifest.json" ]; then
      mkdir -p public/build
      echo '{}' > public/build/manifest.json
      echo "Created empty manifest.json to prevent errors."
    fi
  fi
  
  cd - > /dev/null
fi

# Toggle xdebug
if [ "true" == "$XDEBUG" ] && [ ! -f /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini ]; then
  # Remove PHP_IDE_CONFIG from cron file so we do not duplicate it when adding below
  sed -i '/PHP_IDE_CONFIG/d' /etc/cron.d/laravel-scheduler
  if [ ! -z "${PHP_IDE_CONFIG}" ]; then
    # Add PHP_IDE_CONFIG to cron file. Cron by default does not load enviromental variables. The server name, set here, is
    # used by PHPSTORM for path mappings
    echo -e "PHP_IDE_CONFIG=\"$PHP_IDE_CONFIG\"\n$(cat /etc/cron.d/laravel-scheduler)" > /etc/cron.d/laravel-scheduler
  fi
  # Enable xdebug estension and set up the docker-php-ext-xdebug.ini file with the required xdebug settings
  docker-php-ext-enable xdebug && \
  echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
  echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
  echo "xdebug.discover_client_host=false" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
  echo "xdebug.client_host=$REMOTE_HOST" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini;

elif [ -f /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini ]; then
  # Remove PHP_IDE_CONFIG from cron file if already added
  sed -i '/PHP_IDE_CONFIG/d' /etc/cron.d/laravel-scheduler
  # Remove Xdebug config file disabling xdebug
  rm -rf /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
fi

exec "$@"