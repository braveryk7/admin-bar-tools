<?php

use Yoast\WPTestUtils\WPIntegration;

require_once dirname( __DIR__ ) . '/vendor/yoast/wp-test-utils/src/WPIntegration/bootstrap-functions.php';

$_tests_dir = WPIntegration\get_path_to_wp_test_dir();

if ( ! $_tests_dir ) {
	exit( PHP_EOL . "\033[41mWP_TESTS_DIR environment variable is not defined.\033[0m" . PHP_EOL . PHP_EOL );
}

require_once $_tests_dir . 'includes/functions.php';

/**
 * Manually load the Admin Bar Tools.
 */
function _manually_load_plugin() {
	require dirname( dirname( __FILE__ ) ) . '/admin-bar-tools.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

WPIntegration\bootstrap_it();

define( 'ROOT_DIR', dirname( dirname( __FILE__ ) ) );
