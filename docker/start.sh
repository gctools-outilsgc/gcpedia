#!/bin/sh

# automated install
php /var/www/html/maintenance/dockerInstall.php

# Start server - depending on the image, one of these will work
echo "Starting server"
$@