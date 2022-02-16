#!/bin/bash

set -e

$(dirname $BASH_SOURCE)/db-wait.sh

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

echo
echo Wordpress is ready on http://127.0.0.1:8000
