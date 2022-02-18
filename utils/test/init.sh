#!/bin/bash

set -e

# Using `composer.json` is redundant.
if [ ! -d /app/vendor/phpunit ]
then
  composer require phpunit/phpunit
fi

$(dirname $BASH_SOURCE)/wp-testlib.sh
