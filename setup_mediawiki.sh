#!/bin/bash
set -e
set -x

# Environment variables
MEDIAWIKI_EXT_BRANCH=${MEDIAWIKI_EXT_BRANCH:-REL1_40}

# Install required packages
apt-get update
apt-get upgrade -y
apt-get install -y --no-install-recommends \
    git \
    libzip-dev \
    ffmpeg \
    htmldoc \
    unzip \
    zlib1g-dev \
    zip

# Check if docker-php-ext-install exists and use a fallback if it doesn't
if command -v docker-php-ext-install &> /dev/null; then
    docker-php-ext-install zip
else
    apt-get install -y php-zip
fi

rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR=${WORKDIR:-/var/www/html}

# Copy local files
if [ -d "/setup/site" ]; then
    cp /setup/site/mediawiki.ini /usr/local/etc/php/conf.d/mediawiki.ini
    cp /setup/site/*php $WORKDIR
    cp /setup/site/LocalSettings.php $WORKDIR
elif [ -d "./site" ]; then
    cp ./site/mediawiki.ini /usr/local/etc/php/conf.d/mediawiki.ini
    cp ./site/*php $WORKDIR
    cp ./site/LocalSettings.php $WORKDIR
fi

# Clone MediaWiki extensions
EXTENSIONS=(
    "AJAXPoll"
    "AjaxShowEditors"
    "CategoryWatch"
    "CharInsert"
    "TimedMediaHandler"
    "CSS"
    "EditUser"
    "LookupUser"
    "UserMerge"
    "intersection"
    "RSS"
    "UniversalLanguageSelector"
    "MobileFrontend"
    "IframePage"
    "googleAnalytics"
    "Lingo"
    "DeletePagesForGood"
    "MsCalendar"
    "RandomImage"
    "Widgets"
    "OpenIDConnect"
)

for EXT in "${EXTENSIONS[@]}"; do
    git clone --depth=1 -b $MEDIAWIKI_EXT_BRANCH "https://gerrit.wikimedia.org/r/mediawiki/extensions/$EXT" "$WORKDIR/extensions/$EXT"
done

# Additional extensions
git clone --depth=1 https://github.com/debtcompliance/PdfBook "$WORKDIR/extensions/PdfBook"
git clone --depth=1 https://gitlab.com/organicdesign/TreeAndMenu "$WORKDIR/extensions/TreeAndMenu"

# FIXME issues with github action
git config --global --add safe.directory '*'

# Change ownership
chown -R www-data:www-data $WORKDIR

# Install Composer dependencies for specific extensions
COMPOSER_EXTENSIONS=(
    "OpenIDConnect"
    "PluggableAuth"
    "TimedMediaHandler"
    "Widgets"
)

for EXT in "${COMPOSER_EXTENSIONS[@]}"; do
    cd "$WORKDIR/extensions/$EXT" && composer install --no-dev --no-interaction && cd ../..
done
