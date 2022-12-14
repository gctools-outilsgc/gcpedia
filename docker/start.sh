#!/bin/sh

# automated install
php /var/www/html/maintenance/dockerInstall.php

echo "install complete, swapping in env-based LocalSettings.php"
cp /var/www/html/docker/LocalSettings.php.docker /var/www/html/LocalSettings.php

# Start server - depending on the image, one of these will work
echo "Starting server"
$@