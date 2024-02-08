#!/usr/bin/env bash

is_mysql_reachable() {
  dbhost="${DBHOST:-gcpedia-db}"
  dbuser="${MYSQL_USER:-wiki}"
  dbpass="${MYSQL_PASSWORD:-gcpedia}"

  # Ensure required environment variables are set
  if [[ -z "${DBHOST}" || -z "${dbuser}" || -z "${dbpass}" ]]; then
    echo "Error: Required environment variables (DBHOST, dbuser, dbpass) are not set."
    return 1
  fi

  retries=5
  timeout=5

  for i in {1..$retries}; do
    echo "Checking MySQL server connection... ($i/$retries)"
    if mysqladmin ping -h "${DBHOST}" -u "${dbuser}" -p "${dbpass}" &> /dev/null; then
      echo "MySQL server at ${DBHOST} is reachable and accepting connections."
      return 0
    fi

    # Check if failure was due to a timeout
    if [ $? -eq 124 ]; then
      echo "Connection timed out after $timeout seconds. Retrying... ($i/$retries)"
    else
      # Assume auth failure for other exit codes
      echo "Error: MySQL server at ${DBHOST} failed with $?; might require authentication. Please check username and password."
      return 1
    fi

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
