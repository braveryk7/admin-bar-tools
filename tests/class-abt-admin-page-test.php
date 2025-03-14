<?php
declare( strict_types = 1 );

/**
 * Test: Abt_Admin_Page
 */
class Abt_Admin_Page_Test extends WP_UnitTestCase {
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

		if ( ! class_exists( 'Abt_Base' ) ) {
			require_once './class/class-abt-base.php';
		}

		require_once './class/class-abt-admin-page.php';
	}

	/**
	 * SetUp.
	 * Create instance.
	 */
	public function set_up(): void {
		parent::set_up();

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
		$this->assertSame(
			[
				'<a href="options-general.php?page=admin-bar-tools">Settings</a>',
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
		$this->markTestIncomplete( 'This test is incomplete.' );
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
