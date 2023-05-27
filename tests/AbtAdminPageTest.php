<?php
declare( strict_types = 1 );

use Yoast\WPTestUtils\WPIntegration\TestCase;
/**
 * Test: Abt_Admin_Page
 */
class AbtAdminPageTest extends TestCase {
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

		require_once ROOT_DIR . '/class/class-abt-admin-page.php';
	}

	/**
	 * SetUp.
	 * Create instance.
	 */
	protected function set_up() :void {
		parent::set_up();
		$this->instance = new Abt_Admin_Page();

		wp_set_current_user( null, 'admin' );
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
		$settings_str = __( 'Settings', 'admin-bar-tools' );

		$this->assertSame(
			[
				'<a href="options-general.php?page=admin-bar-tools">' . $settings_str . '</a>',
			],
			$this->instance->add_settings_links( [] ),
		);
	}

	/**
	 * TEST: add_scripts()
	 */
	public function test_add_scripts() {
		$this->markTestIncomplete( 'This test is incomplete.' );
	}

	/**
	 * TEST: register_rest_api()
	 */
	public function test_register_rest_api() {
		$this->markTestIncomplete( 'This test is incomplete.' );
	}

	/**
	 * TEST: get_wordpress_permission()
	 */
	public function test_get_wordpress_permission() {
		$this->assertTrue(
			$this->instance->get_wordpress_permission(),
		);
	}

	/**
	 * TEST: readable_api()
	 */
	public function test_readable_api() {
		$this->markTestIncomplete( 'This test is incomplete.' );
	}

	/**
	 * TEST: editable_api()
	 */
	public function test_editable_api() {
		$this->markTestIncomplete( 'This test is incomplete.' );
	}

	/**
	 * TEST: abt_settings()
	 */
	public function test_abt_settings() {
		ob_start();
		$this->instance->abt_settings();
		$actual = ob_get_clean();
		$this->assertSame(
			'<div id="admin-bar-tools-settings"></div>',
			$actual
		);
	}
}
