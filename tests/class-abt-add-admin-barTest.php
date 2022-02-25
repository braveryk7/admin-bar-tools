<?php
declare( strict_types = 1 );

/**
 * Test: Abt_Activate
 */
class Abt_Add_Admin_BarTest extends PHPUnit\Framework\TestCase {
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

		require_once './class/class-abt-add-admin-bar.php';
		require_once './tests/lib/wordpress-functions.php';
	}

	/**
	 * SetUp.
	 * Create instance.
	 */
	protected function setUp() :void {
		$this->instance = new Abt_Add_Admin_Bar();
	}

	/**
	 * TEST: add_admin_bar()
	 */
	public function test_add_admin_bar() {
		$this->markTestIncomplete( 'This test is incomplete.' );
	}

	/**
	 * TEST: searchconsole_url()
	 */
	public function test_searchconsole_url() {
		$this->markTestIncomplete( 'This test is incomplete.' );
	}
}
