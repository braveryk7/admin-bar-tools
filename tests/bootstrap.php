<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Never_Let_Me_Go
 */

use PHP_CodeSniffer\Tokenizers\PHP;

require dirname( dirname( __FILE__ ) ) . '/vendor/yoast/phpunit-polyfills/phpunitpolyfills-autoload.php';

$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
	$_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

// Start up the WP testing environment.
require_once $_tests_dir . '/includes/bootstrap.php';
