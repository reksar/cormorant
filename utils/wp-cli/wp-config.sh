#!/bin/bash

set -e

$(dirname $BASH_SOURCE)/db-wait.sh

if ! wp core is-installed
then
  echo Installing Wordpress...

  wp core install \
    --url="http://$LOCALHOST:$WP_LOCAL_PORT" \
    --title="Cormorant" \
    --admin_user=$ADMIN_NAME \
    --admin_password=$ADMIN_PASSWORD \
    --admin_email="$ADMIN_NAME@$EMAIL_DOMAIN"

  wp config set WP_DEBUG true
  wp config set WP_DEBUG_LOG true

  wp plugin install contact-form-7 --activate
  wp plugin install flamingo --activate
  wp plugin activate cormorant
fi

echo
echo Wordpress is ready on http://$LOCALHOST:$WP_LOCAL_PORT
