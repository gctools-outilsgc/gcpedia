#!/usr/bin/env bash

is_mysql_reachable() {
  dbhost="${DBHOST:-gcpedia-db}"
  dbuser="${MYSQL_USER:-wiki}"
  dbpass="${MYSQL_PASSWORD:-gcpedia}"

  retries=5
  timeout=5

  for i in {1..$retries}; do
    echo "Checking MySQL server connection ${dbhost} with ${dbuser} and ${dbpass}... ($i/$retries)"
    if mysqladmin ping -h "$dbhost" -u "$dbuser" -p"$dbpass" 2>&1 | tee pinged | grep -q "mysqld is alive"; then
      echo "MySQL server at $dbhost is reachable and accepting connections."
      return 0
    fi

    echo "not alive, response was $(cat pinged)"

    # Check for any errors in output, including timeouts
    if grep -q "timed out" pinged; then
      echo "Connection timed out after $timeout seconds. Retrying... ($i/$retries)"
    else
      # If not a timeout, print a generic error message and continue trying
      echo "Error: MySQL server at $dbhost might require authentication or has other issues. Please check username, password, and server status."
    fi

    rm pinged
    sleep "$timeout"
  done

  # If all retries fail, assume general error
  echo "Error: Could not connect to MySQL server after $retries attempts."
  return 1
}
set -x
trap 'echo "An error occurred"; exit 1' ERR

if is_mysql_reachable; then
  echo "MySQL server is reachable"
else
  echo "Failed to connect to MySQL server."
  exit 1;
fi

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
