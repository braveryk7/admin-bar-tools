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
	public function set_up() :void {
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
	 *
	 * @testWith [ "items", "" ]
	 *           [ "locale", "" ]
	 *           [ "sc", "" ]
	 *           [ "theme_support", "" ]
	 *           [ "version", "" ]
	 *           [ "psi", "items" ]
	 *           [ "lh", "items" ]
	 *           [ "gsc", "items" ]
	 *           [ "gc", "items" ]
	 *           [ "gi", "items" ]
	 *           [ "bi", "items" ]
	 *           [ "twitter", "items" ]
	 *           [ "facebook", "items" ]
	 *           [ "hatena", "items" ]
	 *
	 * @param string $property  Property name.
	 * @param string $parameter Parameter name.
	 */
	public function test_readable_api( string $property, string $parameter ) {
		$abt_base                  = new Abt_Base();
		$abt_base_class_reflection = new ReflectionMethod( $abt_base, 'get_api_namespace' );
		$abt_base_class_reflection->setAccessible( true );

		$request  = new WP_REST_Request( 'GET', "/{$abt_base_class_reflection->invoke( $abt_base )}/options" );
		$response = rest_do_request( $request );
		$data     = $response->get_data();

		empty( $parameter ) ? $this->assertArrayHasKey( $property, $data ) : $this->assertArrayHasKey( $property, $data[ $parameter ] );
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
