#!/bin/bash

set -e

$(dirname $BASH_SOURCE)/db-wait.sh

if ! wp core is-installed
then
  echo Installing Wordpress...

  wp core install \
    --url="http://$WP_LOCAL_HOST:$WP_LOCAL_PORT" \
    --title="Cormorant" \
    --admin_user=$WP_ADMIN_USER \
    --admin_password=$WP_ADMIN_PASSWORD \
    --admin_email=$WP_ADMIN_EMAIL

  wp config set WP_DEBUG true
  wp config set WP_DEBUG_LOG true

  wp plugin install contact-form-7 --activate
  wp plugin install flamingo --activate
fi

echo
echo Wordpress is ready on http://$WP_LOCAL_HOST:$WP_LOCAL_PORT
