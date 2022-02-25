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

	/**
	 * SetUp.
	 * Create instance.
	 */
	protected function setUp() :void {
		$this->instance = new Abt_Admin_Page();
	}

	/**
	 * TEST: add_menu()
	 */
	public function test_add_menu() {
		$this->markTestIncomplete( 'This test is incomplete.' );
	}

	/**
	 * TEST: add_settings_links()
	 */
	public function test_add_settings_links() {
		$this->markTestIncomplete( 'This test is incomplete.' );
	}

	/**
	 * TEST: add_scripts()
	 */
	public function test_add_scripts() {
		$this->markTestIncomplete( 'This test is incomplete.' );
	}

	/**
	 * TEST: register()
	 */
	public function test_register() {
		$this->markTestIncomplete( 'This test is incomplete.' );
	}

	/**
	 * TEST: abt_settings()
	 */
	public function test_abt_settings() {
		$this->markTestIncomplete( 'This test is incomplete.' );
	}
}
