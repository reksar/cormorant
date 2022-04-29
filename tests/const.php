<?php namespace test;
/*
 * The namespace used here prevents conflict with the `FLAMINGO_PLUGIN` const
 * in the Flamingo plugin.
 */

define('test\WP_DIR', getenv('WP_CORE_DIR'));
define('test\SUITE_DIR', getenv('TESTS_SUITE_DIR'));

// Mounted at $TESTS_SUITE_DIR/tests in `docker-compose.yml`
const ROOT_DIR = __DIR__;

const CORMORANT_PLUGIN = 'cormorant/cormorant.php';
const FLAMINGO_PLUGIN = 'flamingo/flamingo.php';
const CF7_PLUGIN = 'contact-form-7/wp-contact-form-7.php';
