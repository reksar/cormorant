#!/bin/bash

CORMORANT_TESTS_DIR=$TESTS_SUITE_DIR/tests

$TESTS_SUITE_DIR/composer/vendor/phpunit/phpunit/phpunit \
  --configuration $CORMORANT_TESTS_DIR/phpunit.xml.dist \
  $CORMORANT_TESTS_DIR
