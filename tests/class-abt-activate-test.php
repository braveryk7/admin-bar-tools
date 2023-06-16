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
