#!/usr/bin/env bash

is_mysql_reachable() {
  # Ensure required environment variables are set
  if [[ -z "${MYSQL_HOST}" || -z "${MYSQL_USER}" || -z "${MYSQL_PASSWORD}" ]]; then
    echo "Error: Required environment variables (MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD) are not set."
    return 1
  fi

  retries=5
  timeout=5

  for i in {1..$retries}; do
    echo "Checking MySQL server connection... ($i/$retries)"
    if mysqladmin ping -h "${MYSQL_HOST}" -u "${MYSQL_USER}" -p "${MYSQL_PASSWORD}" &> /dev/null; then
      echo "MySQL server at ${MYSQL_HOST} is reachable and accepting connections."
      return 0
    fi

    # Check if failure was due to a timeout
    if [ $? -eq 124 ]; then
      echo "Connection timed out after $timeout seconds. Retrying... ($i/$retries)"
    else
      # Assume auth failure for other exit codes
      echo "Error: MySQL server at ${MYSQL_HOST} failed with $?; might require authentication. Please check username and password."
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
