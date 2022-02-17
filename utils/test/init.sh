#!/bin/bash

set -e

# Using `composer.json` is redundant.
if [ ! -d /app/vendor/phpunit ]
then
  echo Installing PHPUnit
  composer require phpunit/phpunit
fi

# Needed to fetch the WP testlib.
if [ ! `which svn` ]
then
  echo Installing Subversion
  apt-get update
  apt-get install -y subversion
fi

$(dirname $BASH_SOURCE)/wp-testlib.sh
