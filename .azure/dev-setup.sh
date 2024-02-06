#!/bin/sh

# automated install
if [ $INIT ]
then
  rm /home/site/www/gcwiki/LocalSettings.php
  php /home/site/www/gcwiki/maintenance/dockerInstall.php

  echo "install complete, swapping in env-based LocalSettings.php"
  cp /home/site/www/gcwiki/docker/LocalSettings.php.docker /home/site/www/gcwiki/LocalSettings.php

  # run script with the full config
  echo "running update maintenance script"
  php /home/site/www/gcwiki/maintenance/update.php -q
fi
