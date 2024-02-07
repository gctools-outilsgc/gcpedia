#!/bin/sh

set -x
trap 'echo "An error occurred"; exit 1' ERR

# automated install
echo "INIT ${INIT}"
if [ $INIT ]
then
  rm /var/www/html/LocalSettings.php
  php /var/www/html/maintenance/dockerInstall.php
  
  echo "install complete, swapping in env-based LocalSettings.php"
  cp /var/www/html/docker/LocalSettings.php.docker /var/www/html/LocalSettings.php

  # run script with the full config
  echo "running update maintenance script"
  php /var/www/html/maintenance/update.php -q
else
  echo "skipping install"
fi

# Start server - depending on the image, one of these will work
echo "Starting server"
$@
