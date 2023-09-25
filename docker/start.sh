#!/bin/sh

# automated install
if [ $INIT ]
then
  rm /var/www/html/LocalSettings.php
  php /var/www/html/maintenance/dockerInstall.php
  
  echo "install complete, swapping in env-based LocalSettings.php"
  cp /var/www/html/docker/LocalSettings.php.docker /var/www/html/LocalSettings.php
fi

# Start server - depending on the image, one of these will work
echo "Starting server"
$@
