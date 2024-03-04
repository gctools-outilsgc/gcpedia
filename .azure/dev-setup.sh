#!/bin/sh

# automated install
if [ $INIT ]
then
  rm /home/site/wwwroot/gcwiki/LocalSettings.php
  php /home/site/wwwroot/gcwiki/maintenance/dockerInstall.php

  echo "install complete, swapping in env-based LocalSettings.php"
  cp /home/site/wwwroot/gcwiki/docker/LocalSettings.php.docker /home/site/wwwroot/gcwiki/LocalSettings.php

  # run script with the full config
  echo "running update maintenance script"
  php /home/site/wwwroot/gcwiki/maintenance/update.php -q
fi
