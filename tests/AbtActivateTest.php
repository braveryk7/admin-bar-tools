<?php
declare( strict_types = 1 );

use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * Test: Abt_Activate
 */
class AbtActivateTest extends TestCase {
	/**
	 * This test class instance.
	 *
	 * @var object $instance instance.
	 */
	private $instance;

	/**
	 * Property that holds data for abt_options.
	 *
	 * @var array $abt_options
	 */
	private $abt_options;

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
		$this->instance = new Abt_Activate();
	}

	/**
	 * TEST: check_environment
	 *
	 * @testWith [ "development", false ]
	 *           [ "local", false ]
	 *           [ "production", true ]
	 *           [ "staging", true ]
	 *
	 * @param string $environment Environment type.
	 * @param bool   $expected    Expected result.
	 */
	public function test_check_environment( string $environment, bool $expected ) {
		$result = apply_filters( 'http_request_args', [ 'sslverify' => false ] );

		$this->assertSame( $expected, $this->instance->check_environment( $result, $environment )['sslverify'] );
	}

	/**
	 * TEST: check_abt_options_column_exists
	 */
	public function test_check_abt_options_column_exists() {
		$this->markTestIncomplete( 'This test is incomplete . ' );
	}

	/**
	 * TEST: register_options()
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
	public function test_register_options( string $property, string $parameter ) {
		$abt_base                 = new Abt_Base();
		$abt_base_get_abt_options = new ReflectionMethod( $abt_base, 'get_abt_options' );
		$abt_base_get_abt_options->setAccessible( true );

		$abt_options = $abt_base_get_abt_options->invoke( $abt_base );

		empty( $parameter ) ? $this->assertArrayHasKey( $property, $abt_options ) : $this->assertArrayHasKey( $property, $abt_options[ $parameter ] );
	}

	/**
	 * TEST: uninstall_options()
	 */
	public function test_uninstall_options() {
		$abt_base                 = new Abt_Base();
		$abt_base_get_abt_options = new ReflectionMethod( $abt_base, 'get_abt_options' );
		$abt_base_get_abt_options->setAccessible( true );

		$abt_options = $abt_base_get_abt_options->invoke( $abt_base );

		$this->assertTrue( ! empty( $abt_options ) );

		Abt_Activate::uninstall_options();

		$removed_abt_options = $abt_base_get_abt_options->invoke( $abt_base );

		$this->assertTrue( empty( $removed_abt_options ) );
	}

	/**
	 * TEST: create_items()
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
	 * @param string $key  Array key name.
	 */
	public function test_create_items( string $key ) {
		$create_items = new ReflectionMethod( $this->instance, 'create_items' );
		$create_items->setAccessible( true );

		$items = $create_items->invoke( $this->instance );

		$this->assertArrayHasKey( $key, $items );
	}
}
