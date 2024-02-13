#!/bin/sh

apt-get update && apt install -y --no-install-recommends memcached imagemagick libicu-dev libonig-dev htmldoc ffmpeg
cp /home/site/wwwroot/gcwiki/.azure/nginx.config /etc/nginx/sites-enabled/default
service nginx reload
sleep 3
service memcached start
service memcached status

# any php extensions need to be installed or activated?
