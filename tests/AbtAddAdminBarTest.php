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
		if ( ! class_exists( 'Abt_Base' ) ) {
			require_once ROOT_DIR . '/class/class-abt-base.php';
		}

		require_once ROOT_DIR . '/class/class-abt-add-admin-bar.php';
	}

	/**
	 * SetUp.
	 * Create instance.
	 */
	public function set_up() :void {
		parent::set_up();
		$this->instance = new Abt_Add_Admin_Bar();
	}

	/**
	 * TEST: add_admin_bar()
	 *
	 * @testWith [ "psi" ]
	 *           [ "lh" ]
	 *           [ "gsc" ]
	 *           [ "gc" ]
	 *           [ "gi" ]
	 *           [ "bi" ]
	 *           [ "twitter" ]
	 *           [ "facebook" ]
	 *           [ "hatena" ]
	 *
	 * @param string $expected expected.
	 */
	public function test_add_admin_bar( string $expected ) {
		wp_set_current_user( null, 'admin' );

		require_once ABSPATH . 'wp-includes/class-wp-admin-bar.php';

		$wp_admin_bar = new WP_Admin_Bar();
		$wp_admin_bar->initialize();

		$this->instance->add_admin_bar( $wp_admin_bar );
		$wp_admin_bar_nodes = $wp_admin_bar->get_nodes();
		$this->assertArrayHasKey( $expected, $wp_admin_bar_nodes );
	}

	/**
	 * TEST: searchconsole_url()
	 */
	public function test_searchconsole_url() {
		$this->markTestIncomplete( 'This test is incomplete.' );
	}
}
