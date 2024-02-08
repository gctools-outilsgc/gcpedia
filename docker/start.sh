#!/usr/bin/env bash
set -x

is_mysql_reachable() {
  retries=5 # Define the number of retries
  for ((i=1; i<=$retries; i++)); do
    echo "Checking MySQL server connection , ($i/$retries)"
    if php /var/www/html/maintenance/checkDB.php; then
      echo "MySQL server is reachable and accepting connections."
      return 0
    else
      echo "Error: MySQL server might require authentication or has other issues. Please check username, password, and server status."
    fi
    sleep 5
  done

  # If all retries fail, assume general error
  echo "Error: Could not connect to MySQL server after $retries attempts."
  return 1
}

if is_mysql_reachable; then
  echo "MySQL server is reachable"
else
  echo "Failed to connect to MySQL server."
  exit 1
fi

# automated install
echo "INIT ${INIT}"

if [ $INIT ]; then
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
