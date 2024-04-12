FROM mediawiki:1.40.1

ENV MEDIAWIKI_EXT_BRANCH REL1_40

LABEL maintainer="GC Tools team"

RUN set -x; \
  apt-get update \
  && apt-get upgrade -y \
  && apt-get install -y --no-install-recommends git zip \
  && rm -rf /var/lib/apt/lists/*


RUN mkdir /super

WORKDIR /var/www/html/

COPY extensions/ /var/www/html/extensions/

RUN chown -R www-data:www-data /var/www/html/
USER www-data

ENV COMPOSER_HOME=/tmp
COPY --from=composer:2.1 /usr/bin/composer /usr/bin/composer

RUN composer config platform.php 8.0 && \
  composer require --update-no-dev mediawiki/pluggable-auth

# Available
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/AJAXPoll /var/www/html/extensions/AJAXPoll
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/AjaxShowEditors /var/www/html/extensions/AjaxShowEditors
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/CategoryWatch /var/www/html/extensions/CategoryWatch
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/CharInsert /var/www/html/extensions/CharInsert
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/TimedMediaHandler /var/www/html/extensions/TimedMediaHandler

RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/CSS /var/www/html/extensions/CSS
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/EditUser /var/www/html/extensions/EditUser
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/LookupUser /var/www/html/extensions/LookupUser 
RUN git clone --depth=1 https://github.com/debtcompliance/PdfBook /var/www/html/extensions/PdfBook

RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/UserMerge /var/www/html/extensions/UserMerge
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/intersection /var/www/html/extensions/intersection
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/RSS /var/www/html/extensions/RSS
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/UniversalLanguageSelector /var/www/html/extensions/UniversalLanguageSelector
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/MobileFrontend /var/www/html/extensions/MobileFrontend
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/IframePage /var/www/html/extensions/IframePage
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/googleAnalytics /var/www/html/extensions/googleAnalytics
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/Lingo /var/www/html/extensions/Lingo
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/DeletePagesForGood /var/www/html/extensions/DeletePagesForGood
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/MsCalendar /var/www/html/extensions/MsCalendar
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/RandomImage /var/www/html/extensions/RandomImage
RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/Widgets /var/www/html/extensions/Widgets

RUN composer update --no-dev

## MISSING
# RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/EmailUpdate /var/www/html/extensions/EmailUpdate

## Conflict
# RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/extensions/CategoryTree /var/www/html/extensions/CategoryTree
# RUN git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH https://gerrit.wikimedia.org/r/mediawiki/skins/MinervaNeue /var/www/html/skins/MinervaNeue


COPY maintenance/checkDB.php maintenance/
COPY docker/init.sh docker/init.sh

ENTRYPOINT [ "bash", "docker/init.sh" ]
CMD [ "docker-php-entrypoint" ]
