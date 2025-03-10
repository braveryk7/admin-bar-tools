<?php
declare( strict_types = 1 );

use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * Test: Abt_Activate
 */
class AbtActivateTest extends TestCase {
	/**
	 * This test class instance.
	 *
	 * @var object $instance instance.
	 */
	private $instance;

	/**
	 * Settings: ABSPATH, test class file, WordPress functions.
	 */
	public static function set_up_before_class(): void {
		parent::set_up_before_class();

		if ( ! defined( 'ABSPATH' ) ) {
			define( 'ABSPATH', '' );
		}

		if ( ! class_exists( 'Abt_Base ' ) ) {
			require_once './class/class-abt-base.php';
		}

		require_once './class/class-abt-activate.php';
	}

	/**
	 * SetUp.
	 * Create instance.
	 */
	public function set_up(): void {
		parent::set_up();

		$this->instance = new Abt_Activate();
	}

	/**
	 * TEST: register_options()
	 */
	public function test_register_options() {
		$this->markTestIncomplete( 'This test is incomplete.' );
	}

	/**
	 * TEST: uninstall_options()
	 */
	public function test_uninstall_options() {
		$this->markTestIncomplete( 'This test is incomplete.' );
	}

	/**
	 * TEST: create_items()
	 */
	public function test_create_items() {
		$this->markTestIncomplete( 'This test is incomplete.' );
	}
}
