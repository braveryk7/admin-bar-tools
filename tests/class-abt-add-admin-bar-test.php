<?php
declare( strict_types = 1 );

use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * Test: Abt_Add_Admin_Bar
 */
class AbtAddAdminBarTest extends TestCase {
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

		require_once './class/class-abt-add-admin-bar.php';
		require_once './tests/lib/wordpress-functions.php';
	}

	/**
	 * SetUp.
	 * Create instance.
	 */
	protected function set_up(): void {
		parent::set_up();

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
