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
    php7-opcache \
    php7-intl \
    php7-apcu \
    curl \
    git \
    # Required for SyntaxHighlighting
    python3 \
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

RUN { \
		echo 'opcache.memory_consumption=128'; \
		echo 'opcache.interned_strings_buffer=8'; \
		echo 'opcache.max_accelerated_files=4000'; \
		echo 'opcache.revalidate_freq=60'; \
		echo 'opcache.fast_shutdown=1'; \
		echo 'opcache.enable_cli=1'; \
} > /etc/php7/conf.d/opcache-recommended.ini

WORKDIR /var/www/html/docker_gcpedia

# Version
ENV MEDIAWIKI_MAJOR_VERSION 1.30
ENV MEDIAWIKI_BRANCH REL1_30
ENV MEDIAWIKI_VERSION 1.30.0
ENV MEDIAWIKI_SHA512 ec4aeb08c18af0e52aaf99124d43cd357328221934d593d87f38da804a2f4a5b172a114659f87f6de58c2140ee05ae14ec6a270574f655e7780a950a51178643

# MediaWiki setup
RUN curl -fSL "https://releases.wikimedia.org/mediawiki/${MEDIAWIKI_MAJOR_VERSION}/mediawiki-${MEDIAWIKI_VERSION}.tar.gz" -o mediawiki.tar.gz \
	&& echo "${MEDIAWIKI_SHA512} *mediawiki.tar.gz" | sha512sum -c - \
	&& tar -xz --strip-components=1 -f mediawiki.tar.gz \
	&& rm mediawiki.tar.gz \
&& chown -R apache:apache extensions skins cache images

COPY --from=0 /app/ /var/www/html/docker_gcpedia/

# for automated install
RUN chown apache:apache /var/www/html/docker_gcpedia/

RUN mkdir /super
RUN mv /var/www/html/docker_gcpedia/docker/secrets.php /super/secrets.php
RUN chown apache:apache /super/secrets.php

EXPOSE 80

RUN chmod +x docker/start.sh

# Start Apache in foreground mode
RUN rm -f /run/apache2/httpd.pid
ENTRYPOINT [ "docker/start.sh" ]
CMD  ["/usr/sbin/httpd -D FOREGROUND"]