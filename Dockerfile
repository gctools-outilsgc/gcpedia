# This dockerfile creates a base image, which it uses for setup of gc mediawiki packages and extensions.
# Finally, it copies files required for mediawiki's runtime from teh setup container to the bsae container for runtime.
# Stage 1: Base Image with Dependencies
FROM mediawiki:1.40.3 as base

ENV MEDIAWIKI_EXT_BRANCH REL1_40

LABEL maintainer="GC Tools team"

WORKDIR /var/www/html/

# Install required packages
RUN apt-get update
RUN apt-get upgrade -y
RUN apt-get install -y --no-install-recommends \
    git \
    libzip-dev \
    ffmpeg \
    htmldoc \
    unzip \
    zlib1g-dev \
    zip \
    curl

# Copy local extensions here, in case there are dependencies solved in setup
COPY extensions /var/www/html/extensions
RUN ls -lat /var/www/html/extensions

FROM base as setup
# Stage 2: Site specific mediawiki setup
COPY . /setup

# Make the setup script executable
RUN chmod +x /setup/setup_mediawiki.sh

# Install Composer
RUN apt-get update && apt-get install -y \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Run the setup_mediawiki script
RUN /setup/setup_mediawiki.sh

# Stage 2: Final Image
FROM base

RUN rm -rf /var/lib/apt/lists/*

COPY --from=setup /var/www/html /var/www/html

# Copy init scripts
COPY init/* /init/
COPY site/mediawiki.ini /usr/local/etc/php/conf.d/mediawiki.ini
COPY site/LocalSettings.php /site/
COPY site/config-gcpedia.php /site/
COPY site/config-gcwiki.php /site/
RUN chmod +x /init/init.sh

USER www-data

ENTRYPOINT [ "bash", "/init/init.sh" ]
CMD [ "apache2-foreground" ]
