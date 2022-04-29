<?php
/**
 * PHPUnit bootstrap file
 * Can be generated with WP CLI: `wp scaffold plugin-tests <plugin>`
 * @see https://developer.wordpress.org/cli/commands/scaffold/plugin-tests
 */

require_once 'const.php';
require_once \test\SUITE_DIR . '/composer/vendor/autoload.php';
require_once \test\SUITE_DIR .
    '/composer/vendor/yoast/phpunit-polyfills/phpunitpolyfills-autoload.php';

// For `tests_add_filter()`.
require_once \test\SUITE_DIR . '/wp/includes/functions.php';

// For `()` inside the `activate_plugin()`.
require_once \test\WP_DIR . '/wp-includes/pluggable.php';

// For `activate_plugin()`.
require_once \test\WP_DIR . '/wp-admin/includes/plugin.php';

/**
 * Manually load the plugins being tested.
 */
tests_add_filter('muplugins_loaded', function() {
    activate_plugin(\test\FLAMINGO_PLUGIN);
    activate_plugin(\test\CORMORANT_PLUGIN);
});

// Start up the WP testing environment.
require \test\SUITE_DIR . '/wp/includes/bootstrap.php';
