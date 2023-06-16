<?php
declare( strict_types = 1 );

use Yoast\WPTestUtils\WPIntegration\TestCase;
/**
 * Test: Abt_Options
 */
class Abt_Options_Test extends TestCase {
	/**
	 * This test class instance.
	 *
	 * @var Abt_Options $instance instance.
	 */
	private $instance;

	/**
	 * Settings: ABSPATH, test class file, WordPress functions.
	 */
	public static function set_up_before_class(): void {
		require_once ROOT_DIR . '/class/class-abt-options.php';
	}

	/**
	 * SetUp.
	 * Create instance.
	 */
	public function set_up() :void {
		parent::set_up();
		$this->instance = new Abt_Options();
	}

	/**
	 * TEST: is_key_exists()
	 */
	public function test_is_key_exists(): void {
		$this->markTestIncomplete( 'This test has not been implemented yet.' );
	}

	/**
	 * TEST: register_options()
	 */
	public function test_register_options(): void {
		$this->markTestIncomplete( 'This test has not been implemented yet.' );
	}

	/**
	 * TEST: set_properties()
	 */
	public function test_set_properties(): void {
		$this->markTestIncomplete( 'This test has not been implemented yet.' );
	}

	/**
	 * TEST: is_abt_options_exists()
	 */
	public function test_is_abt_options_exists(): void {
		$this->assertTrue( $this->instance->is_abt_options_exists() );

		delete_option( 'abt_options' );
		$this->assertTrue( ( new Abt_Options() )->is_abt_options_exists() );
	}

	/**
	 * TEST: is_theme_support()
	 */
	public function test_is_theme_support(): void {
		$this->assertTrue( $this->instance->is_theme_support() );
		$this->instance->set_theme_support( false );
		$this->assertFalse( $this->instance->is_theme_support() );
	}

	/**
	 * TEST: is_version()
	 */
	public function test_is_version(): void {
		$this->markTestIncomplete( 'This test has not been implemented yet.' );
	}

	/**
	 * TEST: update_abt_options()
	 */
	public function test_update_abt_options(): void {
		$this->markTestIncomplete( 'This test has not been implemented yet.' );
	}

	/**
	 * TEST: get_all_options()
	 */
	public function test_get_all_options(): void {
		$this->markTestIncomplete( 'This test has not been implemented yet.' );
	}

	/**
	 * TEST: get_get_items()
	 */
	public function test_get_items(): void {
		$this->markTestIncomplete( 'This test has not been implemented yet.' );
	}

	/**
	 * TEST: get_locale()
	 */
	public function test_get_locale(): void {
		$this->markTestIncomplete( 'This test has not been implemented yet.' );
	}

	/**
	 * TEST: get_sc()
	 */
	public function test_get_sc(): void {
		$this->markTestIncomplete( 'This test has not been implemented yet.' );
	}

	/**
	 * TEST: get_theme_support()
	 */
	public function test_get_theme_support(): void {
		$this->markTestIncomplete( 'This test has not been implemented yet.' );
	}

	/**
	 * TEST: set_items()
	 */
	public function test_set_items(): void {
		$this->markTestIncomplete( 'This test has not been implemented yet.' );
	}

	/**
	 * TEST: set_locale()
	 */
	public function test_set_locale(): void {
		$this->markTestIncomplete( 'This test has not been implemented yet.' );
	}

	/**
	 * TEST: set_sc()
	 */
	public function test_set_sc(): void {
		$this->assertSame( 0, $this->instance->get_sc() );
		$this->instance->set_sc( 1 )->save();
		$this->assertSame( 1, $this->instance->get_sc() );
	}

	/**
	 * TEST: set_theme_support()
	 */
	public function test_set_theme_support(): void {
		$this->assertTrue( $this->instance->get_theme_support() );
		$this->instance->set_theme_support( false )->save();
		$this->assertFalse( $this->instance->get_theme_support() );
	}

	/**
	 * TEST: set_version()
	 */
	public function test_set_version(): void {
		$expected_version = '1.0.0';
		$false_version    = '2.0.0';
		$this->instance->set_version( $expected_version )->save();
		$this->assertTrue( $this->instance->is_version( $expected_version ) );
		$this->assertFalse( $this->instance->is_version( $false_version ) );
	}

	/**
	 * TEST: save()
	 */
	public function test_save(): void {
		$this->markTestIncomplete( 'This test has not been implemented yet.' );
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
	public function test_create_items( string $key ): void {
		$create_items = new ReflectionMethod( $this->instance, 'create_items' );
		$create_items->setAccessible( true );

		$items = $create_items->invoke( $this->instance );

		$this->assertIsArray( $items );

		$this->assertArrayHasKey( $key, $items );
	}
}
