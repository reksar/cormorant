#!/bin/bash

# Used to add the Wordpress test suite into original Wordpress Docker image.
#
# Reads env vars: WP_VERSION, WP_CORE_DIR, WP_TESTS_DIR.
#
# This is an adaptation of the `install_test_suite()` function from the 
# `bin/install-wp-tests.sh` file generated with the WP CLI command
# `wp scaffold plugin-tests <plugin>`
# See:
# https://developer.wordpress.org/cli/commands/scaffold/plugin-tests/
# https://github.com/chriszarate/docker-compose-wordpress/blob/master/bin/install-wp-tests.sh
#
# We need just to install the WP test suite without all other shit like a new
# WP installation and new DB setup. DB creation can be skipped in the original
# script, but a new WP installation - is not.
#
# We use the same DB for dev and tests, but table prefixes are different.
# Default test prefix is `wptests_`. For example, see:
# https://develop.svn.wordpress.org/tags/5.9/wp-tests-config-sample.php

# Fetch WP test lib.
WP_URL=https://develop.svn.wordpress.org/tags/$WP_VERSION
mkdir -p $WP_TESTS_DIR
svn co --quiet $WP_URL/tests/phpunit/includes/ $WP_TESTS_DIR/includes
svn co --quiet $WP_URL/tests/phpunit/data/ $WP_TESTS_DIR/data

# WP tests config...

# fetch
WP_TESTS_CONFIG=$WP_TESTS_DIR/wp-tests-config.php
curl -s $WP_URL/wp-tests-config-sample.php > $WP_TESTS_CONFIG

# edit

sed -i "s:dirname( __FILE__ ) . '/src/':'$WP_CORE_DIR/':" $WP_TESTS_CONFIG

DB_NAME="getenv_docker('WORDPRESS_DB_NAME', 'wordpress')"
sed -i "s/'youremptytestdbnamehere'/$DB_NAME/" $WP_TESTS_CONFIG

DB_USER="getenv_docker('WORDPRESS_DB_USER', 'admin')"
sed -i "s/'yourusernamehere'/$DB_USER/" $WP_TESTS_CONFIG

DB_PASS="getenv_docker('WORDPRESS_DB_PASSWORD', 'admin')"
sed -i "s/'yourpasswordhere'/$DB_PASS/" $WP_TESTS_CONFIG

DB_HOST="getenv_docker('WORDPRESS_DB_HOST', 'mysql')"
sed -i "s|'localhost'|${DB_HOST}|" $WP_TESTS_CONFIG
