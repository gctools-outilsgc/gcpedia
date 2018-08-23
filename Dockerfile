# First stage, fetch subdirectories
FROM alpine:3.7
RUN apk update
RUN apk --no-cache add \
  git \
  curl
WORKDIR /app
COPY . /app/

RUN git submodule init
RUN git submodule update --recursive --init

# Second stage, build usable container
FROM mediawiki:1.30.0
LABEL maintainer="Ilia Salem"
RUN docker-php-ext-install dom gd json ctype iconv xml session curl fileinfo zlib xmlreader

COPY --from=0 /app/skins /var/www/html/docker_gcpedia/
COPY --from=0 /app/extensions /var/www/html/docker_gcpedia/

WORKDIR /var/www/html/docker_gcpedia
RUN mkdir /super
RUN mv /var/www/html/docker_gcpedia/docker/secrets.php /super/secrets.php
RUN chown www-data:www-data /super/secrets.php

EXPOSE 80

RUN chmod +x docker/start.sh
ENTRYPOINT [ "docker/start.sh" ]

