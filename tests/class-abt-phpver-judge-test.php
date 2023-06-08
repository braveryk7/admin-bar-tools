<?php
declare( strict_types = 1 );

use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * Test: Abt_Activate
 */
class Abt_Phpver_Judge_Test extends TestCase {
	/**
	 * This test class instance.
	 *
	 * @var Abt_Add_Admin_Bar $instance instance.
	 */
	private $instance;

	/**
	 * Settings: ABSPATH, test class file, WordPress functions.
	 */
	public static function set_up_before_class(): void {
		require_once ROOT_DIR . '/class/class-abt-phpver-judge.php';
	}
}
