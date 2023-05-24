<?php
declare( strict_types = 1 );

/**
 * Test: Abt_Activate
 */
class AbtActivateTest extends PHPUnit\Framework\TestCase {
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
		if ( ! class_exists( 'Abt_Base' ) ) {
			require_once ROOT_DIR . '/class/class-abt-base.php';
		}

		require_once ROOT_DIR . '/class/class-abt-activate.php';
	}

	/**
	 * SetUp.
	 * Create instance.
	 */
	protected function setUp() :void {
		$this->instance = new Abt_Activate();
	}

	/**
	 * TEST: check_environment
	 */
	public function test_check_environment() {
		$this->markTestIncomplete( 'This test is incomplete.' );
	}

	/**
	 * TEST: check_abt_options_column_exists
	 */
	public function test_check_abt_options_column_exists() {
		$this->markTestIncomplete( 'This test is incomplete.' );
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
