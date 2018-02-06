#!/bin/sh

# automated install
php /var/www/html/docker_gcpedia/maintenance/dockerInstall.php

# Start server - depending on the image, one of these will work
echo "Starting server"
rm -f /run/apache2/httpd.pid && /usr/sbin/httpd -D FOREGROUND
apache2ctl -D FOREGROUND