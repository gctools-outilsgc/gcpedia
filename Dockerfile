# First stage, install composer and its dependencies and fetch vendor files
FROM alpine:3.7
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
RUN mkdir /app && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /app
COPY . /app/

RUN git submodule init
RUN git submodule update --recursive --init
ARG COMPOSER_ALLOW_SUPERUSER=1
ARG COMPOSER_NO_INTERACTION=1
RUN composer install --no-dev

# Second stage, build usable container
FROM alpine:3.7
LABEL maintainer="Ilia Salem"
RUN \
  apk --no-cache add \
    apache2 \
    php7 \
    php7-apache2 \
    php7-curl \
    php7-dom \
    php7-gd \
    php7-json \
    php7-mysqli \
    php7-mbstring \
    php7-ctype \
    php7-iconv \
    php7-xml \
    php7-session \
    php7-curl \
    php7-fileinfo  \
    php7-zlib \
    php7-xmlreader \
    php7-xmlwriter \
    git \
  && apk update \
  && mkdir -p /data \
  && mkdir -p /run/apache2 \
  && chown apache /data \
  && ln -s /dev/stderr /var/log/apache2/error.log \
  && ln -s /dev/stdout /var/log/apache2/access.log \
  && sed -i '/#LoadModule rewrite_module modules\/mod_rewrite.so/c\LoadModule rewrite_module modules\/mod_rewrite.so' /etc/apache2/httpd.conf \
  && sed -i '/DocumentRoot "\/var\/www\/localhost\/htdocs"/c\DocumentRoot "\/var\/www\/html\/docker_gcpedia"' /etc/apache2/httpd.conf \
  && sed -i '/Options Indexes FollowSymLinks/c\\' /etc/apache2/httpd.conf \
  && sed -i '/AllowOverride None/c\\' /etc/apache2/httpd.conf \
  && sed -i '/Options Indexes FollowSymLinks/c\\' /etc/apache2/httpd.conf \
  && sed -i '/<Directory "\/var\/www\/localhost\/htdocs">/c\<Directory "\/var\/www\/html\/docker_gcpedia">\nDirectoryIndex index.php\nOptions FollowSymLinks MultiViews\nAllowOverride All\nOrder allow,deny\nallow from all\n' /etc/apache2/httpd.conf

COPY --from=0 /app/ /var/www/html/docker_gcpedia/
RUN chown apache:apache /var/www/html/docker_gcpedia/

WORKDIR /var/www/html/docker_gcpedia
RUN mkdir /super
RUN mv /var/www/html/docker_gcpedia/docker/secrets.php /super/secrets.php
RUN chown apache:apache /super/secrets.php

EXPOSE 80
EXPOSE 443

RUN chmod +x docker/start.sh

# Start Apache in foreground mode
RUN rm -f /run/apache2/httpd.pid
ENTRYPOINT [ "docker/start.sh" ]
CMD  ["/usr/sbin/httpd -D FOREGROUND"]

