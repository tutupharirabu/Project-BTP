FROM php:8.4-fpm

ENV COMPOSER_MEMORY_LIMIT='-1'

RUN apt-get update && \
    apt-get install -y --force-yes --no-install-recommends \
    libmemcached-dev \
    libzip-dev \
    libz-dev \
    libzip-dev \
    libpq-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libssl-dev \
    openssh-server \
    libmagickwand-dev \
    git \
    cron \
    nano \
    libxml2-dev \
    libreadline-dev \
    libgmp-dev \
    mariadb-client \
    unzip \
    curl \
    gnupg

#####################################
# Node.js and NPM:
#####################################
# === [DEV ONLY: TIDAK DIREKOMENDASIKAN DI PROD] ===
# Untuk production, sebaiknya proses build asset dilakukan di build stage/CI,
# atau pakai multi-stage Dockerfile terpisah.
# Jika tetap ingin ada, pastikan npm, node_modules, dsb tidak memberatkan image prod!
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs
RUN node --version && npm --version
# === [END DEV ONLY] ===

# Install soap extension
RUN docker-php-ext-install soap

# Install for image manipulation
RUN docker-php-ext-install exif

# Install the PHP pcntl extension
RUN docker-php-ext-install pcntl

# Install the PHP zip extension
RUN docker-php-ext-install zip

# Install the PHP pdo_mysql extension
RUN docker-php-ext-install pdo_mysql

# Install the PHP pdo_pgsql extension
RUN docker-php-ext-install pdo_pgsql

# Install the PHP bcmath extension
RUN docker-php-ext-install bcmath

# Install the PHP intl extension
RUN docker-php-ext-install intl

# Install the PHP gmp extension
RUN docker-php-ext-install gmp

#####################################
# PHPRedis:
#####################################
RUN pecl install redis && docker-php-ext-enable redis

#####################################
# Imagick:
#####################################
RUN pecl install imagick && \
    docker-php-ext-enable imagick

#####################################
# GD:
#####################################
# Install the PHP gd library
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd

#####################################
# xDebug:
#####################################
# === [DEV ONLY: TIDAK DIREKOMENDASIKAN DI PROD] ===
# Xdebug sangat berat untuk prod! Hanya install di local/dev!
RUN pecl install xdebug
# Jangan di-enable di prod: docker-php-ext-enable xdebug
# === [END DEV ONLY] ===

#####################################
# PHP Memcached:
#####################################
RUN pecl install memcached && docker-php-ext-enable memcached

#####################################
# Composer:
#####################################
RUN curl -s http://getcomposer.org/installer | php && \
    echo "export PATH=${PATH}:/var/www/vendor/bin" >> ~/.bashrc && \
    mv composer.phar /usr/local/bin/composer
RUN . ~/.bashrc

#####################################
# Laravel Schedule Cron Job:
#####################################
# === [OPSIONAL: SESUAIKAN DENGAN KEBUTUHAN PROD] ===
# Di production, pastikan jadwal cron ini hanya jalan jika memang ingin gunakan cron di container.
RUN echo "* * * * * www-data /usr/local/bin/php /var/www/artisan schedule:run >> /dev/null 2>&1"  >> /etc/cron.d/laravel-scheduler
RUN chmod 0644 /etc/cron.d/laravel-scheduler
# === [END OPSIONAL] ===

#
#--------------------------------------------------------------------------
# Final Touch
#--------------------------------------------------------------------------
#
ADD ./laravel.ini /usr/local/etc/php/conf.d

#####################################
# Aliases:
#####################################
# === [DEV ONLY: TIDAK PERLU DI PROD] ===
# Ini hanya shortcut CLI untuk convenience developer, tidak perlu di prod, tapi tidak membahayakan.
RUN echo '#!/bin/bash\n/usr/local/bin/php /var/www/vendor/bin/dep "$@"' > /usr/bin/dep
RUN chmod +x /usr/bin/dep
RUN echo '#!/bin/bash\n/usr/local/bin/php /var/www/artisan "$@"' > /usr/bin/art
RUN chmod +x /usr/bin/art
RUN echo '#!/bin/bash\n/usr/local/bin/php /var/www/artisan migrate "$@"' > /usr/bin/migrate
RUN chmod +x /usr/bin/migrate
RUN echo '#!/bin/bash\n/usr/local/bin/php /var/www/artisan migrate:fresh --seed' > /usr/bin/fresh
RUN chmod +x /usr/bin/fresh
RUN echo '#!/bin/bash\n/usr/local/bin/php /var/www/artisan config:clear\n/var/www/vendor/bin/phpunit -d memory_limit=2G --stop-on-error --stop-on-failure --testdox-text=tests/report.txt "$@"' > /usr/bin/t
RUN chmod +x /usr/bin/t
RUN echo '#!/bin/bash\n/usr/local/bin/php /var/www/artisan config:clear\n/bin/bash\n/usr/local/bin/php /var/www/artisan dusk -d memory_limit=2G --stop-on-error --stop-on-failure --testdox-text=tests/report-dusk.txt "$@"' > /usr/bin/d
RUN chmod +x /usr/bin/d

#####################################
# NPM Build Aliases:
#####################################
# === [DEV ONLY: TIDAK DIREKOMENDASIKAN DI PROD] ===
RUN echo '#!/bin/bash\ncd /var/www && npm "$@"' > /usr/bin/npm-run
RUN chmod +x /usr/bin/npm-run
RUN echo '#!/bin/bash\ncd /var/www && npm run build' > /usr/bin/build
RUN chmod +x /usr/bin/build
RUN echo '#!/bin/bash\ncd /var/www && npm run dev' > /usr/bin/dev
RUN chmod +x /usr/bin/dev
# === [END DEV ONLY] ===

RUN rm -r /var/lib/apt/lists/*

RUN usermod -u 1000 www-data

WORKDIR /var/www

COPY ./docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
RUN ln -s /usr/local/bin/docker-entrypoint.sh /
ENTRYPOINT ["docker-entrypoint.sh"]

EXPOSE 9000
CMD ["php-fpm"]