<?php

$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
	exit( PHP_EOL . "\033[41mWP_TESTS_DIR environment variable is not defined.\033[0m" . PHP_EOL . PHP_EOL );
}

require_once $_tests_dir . '/includes/functions.php';
require_once $_tests_dir . '/includes/bootstrap.php';

/**
 * Manually load the Example Plugin.
 */
function _manually_load_plugin() {
	require dirname( __DIR__ ) . '/admin-bar-tools.php';
}
tests_add_filter( 'plugins_loaded', '_manually_load_plugin' );
