<?php
/**
 * PHPUnit bootstrap file
 * Can be generated with WP CLI: `wp scaffold plugin-tests <plugin>`
 * @see https://developer.wordpress.org/cli/commands/scaffold/plugin-tests
 */

const TESTS_DIR = __DIR__; // Mounted at <TESTS_SUITE_DIR>/tests

$_tests_suite_dir = getenv( 'TESTS_SUITE_DIR' );
$_wp_tests_suite_dir = $_tests_suite_dir . '/wp';
$_composer_dir = $_tests_suite_dir . '/composer';

require_once $_composer_dir . '/vendor/autoload.php';
require_once $_composer_dir .
    '/vendor/yoast/phpunit-polyfills/phpunitpolyfills-autoload.php';

// Give access to tests_add_filter() function.
require_once $_wp_tests_suite_dir . '/includes/functions.php';

/**
 * Manually load the plugins being tested.
 */
function _manually_load_plugin() {
	$wp_dir = getenv( 'WP_CORE_DIR' );
	require $wp_dir . '/wp-content/plugins/cormorant/cormorant.php';
	require $wp_dir . '/wp-content/plugins/flamingo/flamingo.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

// Start up the WP testing environment.
require $_wp_tests_suite_dir . '/includes/bootstrap.php';
