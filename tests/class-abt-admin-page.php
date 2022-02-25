<?php
declare( strict_types = 1 );

/**
 * Test: Abt_Admin_Page
 */
class Abt_Admin_PageTest extends PHPUnit\Framework\TestCase {
	/**
	 * This test class instance.
	 *
	 * @var object $instance instance.
	 */
	private $instance;

	/**
	 * Settings: ABSPATH, test class file, WordPress functions.
	 */
	public static function setUpBeforeClass(): void {
		define( 'ABSPATH', '' );

		require_once './class/class-abt-admin-page.php';
		require_once './tests/lib/wordpress-functions.php';
	}
}
