# First stage, install composer and its dependencies and fetch vendor files and submodules
FROM alpine:3.13
RUN apk update
RUN apk --no-cache add \
  php7 \
  php7-dom \
  php7-phar \
  php7-gd \
  php7-json \
  php7-mysqli \
  php7-mysqlnd \
  php7-mbstring \
  php7-ctype \
  php7-iconv \
  php7-tokenizer \
  php7-openssl \
  php7-xml \
  php7-simplexml \
  php7-xmlwriter \
  php7-zlib \
  php7-curl \
  git \
  curl
RUN mkdir /app && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --version=1.10.19 --filename=composer
WORKDIR /app
COPY . /app/

RUN git submodule init
RUN git submodule update --recursive --init
ARG COMPOSER_ALLOW_SUPERUSER=1
ARG COMPOSER_NO_INTERACTION=1
RUN cd /app/extensions/OpenIDConnect && composer install --no-dev
RUN cd /app/extensions/PluggableAuth && composer install --no-dev

# Cleanup before copying over to next stage - version history takes up a lot of space
RUN rm -rf .git/


# Second stage, build usable container
FROM mediawiki:1.40.1
LABEL maintainer="Ilia Salem"

RUN apt-get update && apt install -y htmldoc ffmpeg

WORKDIR /var/www/html/
COPY --from=0 /app/ /var/www/html/
COPY ./docker/LocalSettings.php.docker /var/www/html/LocalSettings.php

# for automated install
#RUN chown www-data:www-data /var/www/html/

RUN mkdir /super
RUN mv /var/www/html/docker/secrets.php /super/secrets.php
RUN chown www-data:www-data /super/secrets.php

EXPOSE 80

RUN chmod +x docker/start.sh

# Start Apache in foreground mode
RUN rm -f /run/apache2/httpd.pid
ENTRYPOINT [ "docker/start.sh" ]
CMD  ["apache2-foreground"]
