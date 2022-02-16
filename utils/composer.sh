#!/bin/bash

# Using `composer.json` is redundant.

if [ ! -d /app/vendor/phpunit ]
then
  composer require phpunit/phpunit
fi
