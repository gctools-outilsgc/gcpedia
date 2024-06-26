#!/usr/bin/env bash
set -e

check_database() {
  retries=5
  for ((i=1; i<=$retries; i++)); do
    echo "Checking MySQL server connection , ($i/$retries)"
    if php /init/checkDB.php; then
      echo "MySQL server is up and running!"
      return 0
    fi
    sleep 5
  done

  echo "Error: Could not connect to MySQL server after $retries attempts."
  exit 1
}

check_setup() {
  # Install logic
  # Check if the database is available.
  #   If it's not, remove any exising LocalSettings.php link if present, then do an install, link the LocalSettings.php, and run the update script. 
  #   If it is, if LocalSettings.php isn't linked, link it and run update
  local RUN_UPDATE="false"
  if ! php /init/checkDB.php ${DBNAME} categorylinks; then
    if [ -e /var/www/html/LocalSettings.php ]; then
      echo "Dangling LocalSettings.php found, unlinking"
      rm LocalSettings.php
    fi

    echo "Database ${DBNAME} not found, running install"
    php maintenance/install.php \
      --dbengine InnoDB \
      --dbserver=${DBHOST} --dbtype=${DBTYPE} --dbuser=${DBUSER} --dbpass=${DBPASS} --dbname=${DBNAME} \
      --scriptpath='' --server="${WIKI_PROTOCOL}://${WIKI_HOST}${WIKI_PORT}" --lang=en  \
      --pass=adminpassword 'GCpedia' 'admin' 
    local status=$?
    if [ $status -ne 0 ]; then
      echo "Error: MediaWiki installation failed with status $status"
      sleep 1000
      exit $status
    fi
    # overwrite installation LocalSettings with site specific
    cp /setup/site/LocalSettings.php /var/www/html/LocalSettings.php
    # make sure an update is run for the sake of extensions
    RUN_UPDATE="true"
  else 
    echo "Database ${DBNAME} already exists"
  fi
  if [ ! -f /var/www/html/LocalSettings.php ]; then
    echo "LocalSettings.php not found, linking"
    cp /setup/site/LocalSettings.php /var/www/html/LocalSettings.php
    RUN_UPDATE="true"
  fi
  if [ "$RUN_UPDATE" = "true" ]; then
    echo "running update maintenance script"
    php /var/www/html/maintenance/update.php -q
  fi
}

check_database 

# automated install
echo "INIT ${INIT}"

if [ $INIT ]; then
  check_setup
else
  echo "skipping initialization check"
fi

echo "Continuing with '$@'"
$@
