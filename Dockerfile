# Stage 1: Base Image with Dependencies
FROM mediawiki:1.40.3 as base

ENV MEDIAWIKI_EXT_BRANCH REL1_40

LABEL maintainer="GC Tools team"

RUN set -x; \
    apt-get update \
 && apt-get upgrade -y \
 && apt-get install -y --no-install-recommends \
    git \
    libzip-dev \
    ffmpeg \
    unzip \
    zlib1g-dev \
 && docker-php-ext-install \
    zip \
 && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html/

COPY extensions/ extensions/
COPY ./site/mediawiki.ini /usr/local/etc/php/conf.d/mediawiki.ini
COPY ./site/*php /site/

RUN chown -R www-data:www-data /var/www/html/

# Stage 2: Install MediaWiki Extensions
FROM base as extensions

RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/AJAXPoll extensions/AJAXPoll
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/AjaxShowEditors extensions/AjaxShowEditors
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/CategoryWatch extensions/CategoryWatch
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/CharInsert extensions/CharInsert
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/TimedMediaHandler extensions/TimedMediaHandler
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/CSS extensions/CSS
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/EditUser extensions/EditUser
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/LookupUser extensions/LookupUser 
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/UserMerge extensions/UserMerge
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/intersection extensions/intersection
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/RSS extensions/RSS
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/UniversalLanguageSelector extensions/UniversalLanguageSelector
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/MobileFrontend extensions/MobileFrontend
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/IframePage extensions/IframePage
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/googleAnalytics extensions/googleAnalytics
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/Lingo extensions/Lingo
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/DeletePagesForGood extensions/DeletePagesForGood
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/MsCalendar extensions/MsCalendar
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/RandomImage extensions/RandomImage
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/Widgets extensions/Widgets
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/OpenIDConnect extensions/OpenIDConnect

RUN git clone --depth=1 https://github.com/debtcompliance/PdfBook /var/www/html/extensions/PdfBook
RUN git clone --depth=1 https://gitlab.com/organicdesign/TreeAndMenu extensions/TreeAndMenu

# Stage 3: Composer Setup
FROM extensions as composer

ENV COMPOSER_HOME=/tmp
COPY --from=composer:2.1 /usr/bin/composer /usr/bin/composer

COPY composer.local.json composer.local.json

RUN composer update

# Stage 4: Final Image
FROM base

COPY --from=composer /var/www/html/extensions /var/www/html/extensions

USER www-data

COPY init/checkDB.php init/
COPY init/init.sh init/

ENTRYPOINT [ "bash", "init/init.sh" ]
CMD [ "apache2-foreground" ]
