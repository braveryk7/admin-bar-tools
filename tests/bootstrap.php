<?php
require_once dirname( dirname( __FILE__ ) ) . '/vendor/yoast/phpunit-polyfills/phpunitpolyfills-autoload.php';

$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
	exit( PHP_EOL . "\033[41mWP_TESTS_DIR environment variable is not defined.\033[0m" . PHP_EOL . PHP_EOL );
}

require_once $_tests_dir . '/includes/bootstrap.php';
