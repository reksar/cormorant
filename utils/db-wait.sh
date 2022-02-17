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

# Check DB connection every...
INTERVAL=2  # seconds...
# up to
attempts=30
while ! wp db check --quiet && [ $attempts -gt 0 ]
do
  (( attempts-- ))
  sleep $INTERVAL
done

if [ $attempts -le 0 ]
then
  echo Unable to connect to database.
  exit 1
fi
