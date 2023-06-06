<?php
declare( strict_types = 1 );

use Yoast\WPTestUtils\WPIntegration\TestCase;
/**
 * Test: Abt_Admin_Page
 */
class Abt_Admin_Page_Test extends TestCase {
	/**
	 * This test class instance.
	 *
	 * @var Abt_Admin_Page $instance instance.
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
	public function test_add_menu(): void {
		$admin_menu_callback = function() {
			$this->instance->add_menu();
			$this->assertNotFalse( remove_submenu_page( 'options-general.php', 'admin-bar-tools' ) );
		};

		add_action( 'admin_menu', $admin_menu_callback, 999 );

		do_action( 'admin_menu' );
	}

	/**
	 * TEST: add_settings_links()
	 */
	public function test_add_settings_links(): void {
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
	 *
	 * @testWith [ "" ]
	 *           [ "settings_page_admin-bar-tools" ]
	 *
	 * @param string $arg add_scripts method arg.
	 */
	public function test_add_scripts( string $arg ): void {
		$abt_base            = new Abt_Base();
		$abt_base_add_prefix = new ReflectionMethod( $abt_base, 'add_prefix' );
		$abt_base_add_prefix->setAccessible( true );

		$this->instance->add_scripts( $arg );

		$style_handle  = $abt_base_add_prefix->invoke( $abt_base, 'style' );
		$script_handle = $abt_base_add_prefix->invoke( $abt_base, 'script' );

		$this->assertIsString( $style_handle );
		$this->assertIsString( $script_handle );

		if ( '' === $arg ) {
			$this->assertFalse( wp_style_is( $style_handle ) );
			$this->assertFalse( wp_script_is( $script_handle ) );
		} else {
			$this->assertTrue( wp_style_is( $style_handle ) );
			$this->assertTrue( wp_script_is( $script_handle ) );
		}
	}

	/**
	 * TEST: register_rest_api()
	 *
	 * @testWith [ "GET", "options" ]
	 *           [ "POST", "update" ]
	 *
	 * @param string $request_method HTTP request method.
	 * @param string $end_point      end point.
	 */
	public function test_register_rest_api( string $request_method, string $end_point ): void {
		$abt_base                   = new Abt_Base();
		$abt_base_get_api_namespace = new ReflectionMethod( $abt_base, 'get_api_namespace' );
		$abt_base_get_api_namespace->setAccessible( true );

		$api_name_space = $abt_base_get_api_namespace->invoke( $abt_base );
		$this->assertIsString( $api_name_space );

		$request = new WP_REST_Request( $request_method, "/{$api_name_space}/{$end_point}" );
		if ( 'POST' === $request_method ) {
			$request->set_header( 'Content-Type', 'application/json' );
			$request->set_param( 'theme_support', true );
		}
		$response    = rest_do_request( $request );
		$status_code = $response->get_status();

		$this->assertSame( 200, $status_code );
	}

	/**
	 * TEST: get_wordpress_permission()
	 */
	public function test_get_wordpress_permission(): void {
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
	public function test_readable_api( string $property, string $parameter ): void {
		$abt_base                   = new Abt_Base();
		$abt_base_get_api_namespace = new ReflectionMethod( $abt_base, 'get_api_namespace' );
		$abt_base_get_api_namespace->setAccessible( true );

		$api_name_space = $abt_base_get_api_namespace->invoke( $abt_base );
		$this->assertIsString( $api_name_space );

		$request  = new WP_REST_Request( 'GET', "/{$api_name_space}/options" );
		$response = rest_do_request( $request );
		$data     = $response->get_data();

		$this->assertIsArray( $data );
		$this->assertIsArray( $data[ $parameter ] );

		empty( $parameter ) ? $this->assertArrayHasKey( $property, $data ) : $this->assertArrayHasKey( $property, $data[ $parameter ] );
	}

	/**
	 * TEST: editable_api()
	 */
	public function test_editable_api(): void {
		$abt_base                   = new Abt_Base();
		$abt_base_get_api_namespace = new ReflectionMethod( $abt_base, 'get_api_namespace' );
		$abt_base_get_api_namespace->setAccessible( true );

		$abt_base_get_abt_options = new ReflectionMethod( $abt_base, 'get_abt_options' );
		$abt_base_get_abt_options->setAccessible( true );

		$abt_options = $abt_base_get_abt_options->invoke( $abt_base );

		$request = new WP_REST_Request( 'POST', "/{$abt_base_get_api_namespace->invoke( $abt_base )}/update" );
		$request->set_header( 'Content-Type', 'application/json' );
		$request->set_param( 'theme_support', ! $abt_options['theme_support'] );
		$response = rest_do_request( $request );

		$this->assertNotSame( $abt_options['theme_support'], $abt_base_get_abt_options->invoke( $abt_base )['theme_support'] );
	}

	/**
	 * TEST: abt_settings()
	 */
	public function test_abt_settings(): void {
		ob_start();
		$this->instance->abt_settings();
		$actual = ob_get_clean();
		$this->assertSame(
			'<div id="admin-bar-tools-settings"></div>',
			$actual
		);
	}
}
