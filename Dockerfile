FROM mediawiki:1.40.3

ENV MEDIAWIKI_EXT_BRANCH REL1_40

LABEL maintainer="GC Tools team"

RUN set -x; \
    apt-get update \
 && apt-get upgrade -y \
 && apt-get install -y --no-install-recommends \
    git \
    libzip-dev \
    unzip \
    zlib1g-dev \
 && docker-php-ext-install \
    zip \
 && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html/

COPY extensions/ extensions/
COPY ./config/mediawiki.ini /usr/local/etc/php/conf.d/mediawiki.ini

RUN chown -R www-data:www-data /var/www/html/
USER www-data

ENV COMPOSER_HOME=/tmp
COPY --from=composer:2.1 /usr/bin/composer /usr/bin/composer

RUN composer config platform.php 8.1 && \
  composer require --update-no-dev mediawiki/pluggable-auth

# Available
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/AJAXPoll extensions/AJAXPoll
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/AjaxShowEditors extensions/AjaxShowEditors
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/CategoryWatch extensions/CategoryWatch
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/CharInsert extensions/CharInsert
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/TimedMediaHandler extensions/TimedMediaHandler

RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/CSS extensions/CSS
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/EditUser extensions/EditUser
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/LookupUser extensions/LookupUser 
RUN git clone --depth=1 https://github.com/debtcompliance/PdfBook /var/www/html/extensions/PdfBook

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

RUN git clone --depth=1 https://gitlab.com/organicdesign/TreeAndMenu extensions/TreeAndMenu

RUN git clone --depth=1 https://github.com/United-Earth-Team/MW-OAuth2Client.git extensions/MW-OAuth2Client
RUN cd extensions/MW-OAuth2Client ; git submodule update --init
RUN cd vendors/oauth2-client; composer install

## MISSING
# RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/EmailUpdate /var/www/html/extensions/EmailUpdate

## Conflict
# RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/CategoryTree /var/www/html/extensions/CategoryTree
# RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/skins/MinervaNeue /var/www/html/skins/MinervaNeue


# Unsupported

# Multilanguage - unmaintained, no database changes
# MagicNoNumberedHeadings - unmaintained, no database changes

COPY init/checkDB.php init/
COPY init/init.sh init/

ENTRYPOINT [ "bash", "init/init.sh" ]
CMD [ "apache2-foreground" ]
