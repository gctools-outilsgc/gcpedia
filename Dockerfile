# Stage 1: Base Image with Dependencies
FROM mediawiki:1.40.3 as base

ENV MEDIAWIKI_EXT_BRANCH REL1_40

LABEL maintainer="GC Tools team"

WORKDIR /var/www/html/

COPY ./site/setup_mediawiki.sh /usr/local/bin/setup_mediawiki.sh
COPY ./site/ /setup/site/
COPY init/checkDB.php /var/www/html/init/
COPY init/init.sh /var/www/html/init/
COPY site/config-gcpedia.php /site/config-gcpedia.php
COPY site/config-gcwiki.php /site/config-gcwiki.php

RUN chmod +x /usr/local/bin/setup_mediawiki.sh
RUN chmod +x /var/www/html/init/init.sh

# Stage 2: Install Composer and run setup
FROM base as setup

# Install Composer
RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN /usr/local/bin/setup_mediawiki.sh

# Stage 3: Final Image
FROM base

COPY --from=setup /var/www/html/extensions /var/www/html/extensions
COPY --from=setup /usr/local/etc/php/conf.d/mediawiki.ini /usr/local/etc/php/conf.d/mediawiki.ini
COPY --from=setup /var/www/html /var/www/html

USER www-data

ENTRYPOINT [ "bash", "/var/www/html/init/init.sh" ]
CMD [ "apache2-foreground" ]
