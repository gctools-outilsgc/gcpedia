#!/bin/sh

apt-get update && apt install -y --no-install-recommends memcached imagemagick libicu-dev libonig-dev htmldoc ffmpeg
cp /home/site/wwwroot/gcwiki/.azure/nginx.config /etc/nginx/sites-enabled/default

# any php extensions need to be installed or activated?