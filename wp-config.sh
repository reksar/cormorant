#!/bin/bash

# Wait for database to be ready...
#
# The alternative is using the docker-compose's `healthcheck`, but this is a
# hack and may not work correctly. Especially when you need to set multiple 
# `depends_on` services and at least one with the `condition: service_healthy`.
#
# So we use this check as the normal documented way.
# See:
# https://docs.docker.com/compose/compose-file/compose-file-v3/#depends_on
# https://docs.docker.com/compose/startup-order/

# Wait up to 60 seconds
MAX_RETRIES=30
INTERVAL=2  # seconds
retries=0
while ! wp db check --quiet && [ $retries -lt $MAX_RETRIES ]
do
  (( retries++ ))
  sleep $INTERVAL
done

if [ $retries -ge $MAX_RETRIES ]
then
  echo Unable to connect to database.
  exit 1
fi


# Configure Wordpress.

if ! wp core is-installed
then
  # TODO: use .env
  wp core install \
    --url="http://127.0.0.1:8000" \
    --title="Cormorant test" \
    --admin_user="admin" \
    --admin_password="admin" \
    --admin_email="admin@email.com"

  wp plugin install contact-form-7 --activate
  wp plugin install flamingo --activate
fi

if [ $? -ne 0 ]
then
  echo Unable to configure Wordpress.
  exit 2
fi

echo Wordpress is ready.
