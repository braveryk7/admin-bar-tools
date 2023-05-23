<?php
$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
	exit( PHP_EOL . "\033[41mWP_TESTS_DIR environment variable is not defined.\033[0m" . PHP_EOL . PHP_EOL );
}

define( 'ROOT_DIR', dirname( dirname( __FILE__ ) ) );

require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load the Admin Bar Tools.
 */
function _manually_load_plugin() {
	require dirname( dirname( __FILE__ ) ) . '/admin-bar-tools.php';
}
tests_add_filter( 'plugins_loaded', '_manually_load_plugin' );

require_once dirname( dirname( __FILE__ ) ) . '/vendor/yoast/phpunit-polyfills/phpunitpolyfills-autoload.php';

require_once $_tests_dir . '/includes/bootstrap.php';
