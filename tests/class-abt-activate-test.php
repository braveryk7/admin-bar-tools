<?php
declare( strict_types = 1 );

use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * Test: Abt_Activate
 */
class Abt_Activate_Test extends TestCase {
	/**
	 * This test class instance.
	 *
	 * @var Abt_Activate $instance instance.
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
	public function set_up() :void {
		parent::set_up();
		$this->instance = new Abt_Activate( new Abt_Options() );
	}

	/**
	 * TEST: check_environment
	 *
	 * @testWith [ "development", false ]
	 *           [ "local", false ]
	 *           [ "production", true ]
	 *           [ "staging", true ]
	 *           [ null, null ]
	 *
	 * @param string $environment Environment type.
	 * @param bool   $expected    Expected result.
	 */
	public function test_check_environment( ?string $environment, ?bool $expected ): void {
		$result = apply_filters( 'http_request_args', [ 'sslverify' => false ] );

		if ( ! is_null( $environment ) ) {
			$this->assertSame( $expected, $this->instance->check_environment( $result, $environment )['sslverify'] );
		} else {
			$this->assertSame(
				in_array( wp_get_environment_type(), [ 'production', 'staging' ], true ),
				$this->instance->check_environment( args: $result )['sslverify']
			);
		}
	}

	/**
	 * TEST: update_abt_options
	 */
	public function test_update_abt_options(): void {
		$abt_base                 = new Abt_Base();
		$abt_base_get_abt_options = new ReflectionMethod( $abt_base, 'get_abt_options' );
		$abt_base_get_abt_options->setAccessible( true );

		$get_abt_options = function() use ( $abt_base_get_abt_options ) {
			return $abt_base_get_abt_options->invoke( $this->instance );
		};

		$delete_abt_options = function() {
			delete_option( 'abt_options' );
		};

		if ( $get_abt_options() ) {
			$delete_abt_options();
		}

		$this->assertTrue( empty( $get_abt_options() ) );

		$this->instance->update_abt_options();

		$this->assertTrue( ! empty( $get_abt_options() ) );

		$abt_options = $get_abt_options();

		$this->assertIsArray( $abt_options );

		$abt_options['version'] = '0.0.0';
		unset( $abt_options['theme_support'] );

		$this->assertArrayNotHasKey( 'theme_support', $abt_options );

		$this->instance->update_abt_options();

		$actual_abt_options = $get_abt_options();
		$this->assertIsArray( $actual_abt_options );

		$this->assertNotSame( $abt_options['version'], $actual_abt_options['version'] );
		$this->assertArrayHasKey( 'theme_support', $actual_abt_options );
	}

	/**
	 * TEST: is_abt_version
	 */
	public function test_is_abt_version(): void {
		$is_plugin_version = new ReflectionMethod( $this->instance, 'is_abt_version' );
		$is_plugin_version->setAccessible( true );

		$abt_base                 = new Abt_Base();
		$abt_base_get_abt_options = new ReflectionMethod( $abt_base, 'get_abt_options' );
		$abt_base_get_abt_options->setAccessible( true );

		$abt_options = $abt_base_get_abt_options->invoke( $abt_base );
		$this->assertIsArray( $abt_options );

		$this->assertTrue( $is_plugin_version->invoke( $this->instance, $abt_options['version'] ) );
	}

	/**
	 * TEST: register_options()
	 *
	 * @testWith [ "items", null ]
	 *           [ "locale", null ]
	 *           [ "sc", null ]
	 *           [ "theme_support", null ]
	 *           [ "version", null ]
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
	 * @param string  $property  Property name.
	 * @param ?string $parameter Parameter name.
	 */
	public function test_register_options( string $property, ?string $parameter ): void {
		$abt_base                 = new Abt_Base();
		$abt_base_get_abt_options = new ReflectionMethod( $abt_base, 'get_abt_options' );
		$abt_base_get_abt_options->setAccessible( true );

		$abt_options = $abt_base_get_abt_options->invoke( $abt_base );

		$this->assertIsArray( $abt_options );

		if ( is_null( $parameter ) ) {
			$this->assertArrayHasKey( $property, $abt_options );
		} else {
			$this->assertIsArray( $abt_options[ $parameter ] );
			$this->assertArrayHasKey( $property, $abt_options[ $parameter ] );
		}

		is_null( $parameter )
			? $this->assertArrayHasKey( $property, $abt_options )
			: $this->assertArrayHasKey( $property, $abt_options[ $parameter ] );
	}

	/**
	 * TEST: uninstall_options()
	 */
	public function test_uninstall_options(): void {
		$abt_base                 = new Abt_Base();
		$abt_base_get_abt_options = new ReflectionMethod( $abt_base, 'get_abt_options' );
		$abt_base_get_abt_options->setAccessible( true );

		$abt_options = $abt_base_get_abt_options->invoke( $abt_base );

		$this->assertTrue( ! empty( $abt_options ) );

		Abt_Activate::uninstall_options();

		$removed_abt_options = $abt_base_get_abt_options->invoke( $abt_base );

		$this->assertTrue( empty( $removed_abt_options ) );
	}
}
