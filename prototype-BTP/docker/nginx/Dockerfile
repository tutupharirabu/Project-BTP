FROM nginx:alpine

COPY nginx.conf /etc/nginx/

RUN apk update \
  && apk upgrade \
  && apk --update add logrotate \
  && apk add --no-cache openssl \
  && apk add --no-cache bash

RUN apk add --no-cache curl

# Komen jika masuk ke server prod
# RUN set -x ; \
#   addgroup -g 82 -S www-data ; \
#   adduser -u 82 -D -S -G www-data www-data && exit 0 ; exit 1

ARG PHP_UPSTREAM_CONTAINER=php-fpm
ARG PHP_UPSTREAM_PORT=9000

# Create 'messages' file used from 'logrotate'
# Komen jika masuk ke server prod
# RUN touch /var/log/messages

# Copy 'logrotate' config file
# Komen jika masuk ke server prod
# COPY logrotate/nginx /etc/logrotate.d/

# Set upstream conf and remove the default conf
RUN echo "upstream php-upstream { server ${PHP_UPSTREAM_CONTAINER}:${PHP_UPSTREAM_PORT}; }" > /etc/nginx/conf.d/upstream.conf \
  && rm /etc/nginx/conf.d/default.conf

ADD ./startup.sh /opt/startup.sh
RUN sed -i 's/\r//g' /opt/startup.sh

EXPOSE 80

# Komen kalau jalan di server prod
# EXPOSE 80 81 443

CMD ["/bin/bash", "/opt/startup.sh"]
