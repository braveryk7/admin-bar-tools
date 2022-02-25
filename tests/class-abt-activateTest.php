<?php
declare( strict_types = 1 );

/**
 * Test: Abt_Activate
 */
class Abt_ActivateTest extends PHPUnit\Framework\TestCase {
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
		if ( ! defined( 'ABSPATH' ) ) {
			define( 'ABSPATH', '' );
		}

		require_once './class/class-abt-activate.php';
		require_once './tests/lib/wordpress-functions.php';
	}

	/**
	 * SetUp.
	 * Create instance.
	 */
	protected function setUp() :void {
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

	/**
	 * TEST: migration_options()
	 */
	public function test_migration_options() {
		$this->markTestIncomplete( 'This test is incomplete.' );
	}
}
