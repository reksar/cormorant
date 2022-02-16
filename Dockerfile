ARG WP_VERSION
FROM wordpress:$WP_VERSION-apache
# Everything below is for adding the WP test lib to the original image above.

RUN apt-get update
RUN apt-get install -y subversion

ARG WP_VERSION
ARG WP_CORE_DIR
ARG WP_TESTS_DIR
COPY ./utils/wp-test-suite.sh $WP_TESTS_DIR/
RUN $WP_TESTS_DIR/wp-test-suite.sh
# We don't need the .sh file and svn anymore.
