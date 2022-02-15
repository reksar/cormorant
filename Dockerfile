ARG WORDPRESS_VERSION
FROM wordpress:$WORDPRESS_VERSION-php7.4-apache

RUN apt-get update
RUN apt-get install -y subversion

# This is an adaptation of the `install_test_suite()` function from the 
# `bin/install-wp-tests.sh` file that can be generated with the
# `wp scaffold plugin-tests <plugin>` WP CLI command. See:
# https://developer.wordpress.org/cli/commands/scaffold/plugin-tests/
# https://github.com/chriszarate/docker-compose-wordpress/blob/master/bin/install-wp-tests.sh
#
# We need just to install the test suite without all other shit like a new WP
# installation and new DB setup. DB creation can be skipped in the original
# script, but a new WP installation - is not.
#
# We use one DB for dev and tests, but table prefixes are different. Default
# test prefix is `wptests_`.
# See https://develop.svn.wordpress.org/tags/5.9/wp-tests-config-sample.php
#
# If you need to separate dev and test envs or DB backups - take care of it
# yourself.

ARG WORDPRESS_VERSION
ARG TESTS_LIB_DIR=/usr/lib/wp/tests
RUN mkdir -p $TESTS_LIB_DIR
RUN svn co --quiet https://develop.svn.wordpress.org/tags/$WORDPRESS_VERSION/tests/phpunit/includes/ $TESTS_LIB_DIR/includes
RUN svn co --quiet https://develop.svn.wordpress.org/tags/$WORDPRESS_VERSION/tests/phpunit/data/ $TESTS_LIB_DIR/data

# Tests config
ARG WORDPRESS_VERSION
ARG CORE_DIR=/var/www/html
ARG TESTS_CONFIG=$TESTS_LIB_DIR/wp-tests-config.php
ARG DB_HOST="getenv_docker('WORDPRESS_DB_HOST', 'mysql')"
ARG DB_NAME="getenv_docker('WORDPRESS_DB_NAME', 'wordpress')"
ARG DB_USER="getenv_docker('WORDPRESS_DB_USER', 'admin')"
ARG DB_PASS="getenv_docker('WORDPRESS_DB_PASSWORD', 'admin')"
RUN curl -s https://develop.svn.wordpress.org/tags/$WORDPRESS_VERSION/wp-tests-config-sample.php > $TESTS_CONFIG
RUN sed -i "s:dirname( __FILE__ ) . '/src/':'$CORE_DIR/':" $TESTS_CONFIG
RUN sed -i "s/'youremptytestdbnamehere'/$DB_NAME/" $TESTS_CONFIG
RUN sed -i "s/'yourusernamehere'/$DB_USER/" $TESTS_CONFIG
RUN sed -i "s/'yourpasswordhere'/$DB_PASS/" $TESTS_CONFIG
RUN sed -i "s|'localhost'|${DB_HOST}|" $TESTS_CONFIG
