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
		$abt_options = [
			'items'   => [],
			'locale'  => '',
			'sc'      => 0,
			'version' => '',
		];

		$this->assertFalse( $this->instance->is_key_exists( $abt_options ) );
	}

	/**
	 * TEST: register_options()
	 */
	public function test_register_options(): void {
		delete_option( 'abt_options' );
		$this->assertFalse( get_option( 'abt_options' ) );

		$this->instance->register_options();
		$this->assertNotFalse( get_option( 'abt_options' ) );
	}

	/**
	 * TEST: set_properties()
	 */
	public function test_set_properties(): void {
		$abt_options = [
			'items'         => [],
			'locale'        => '',
			'sc'            => 0,
			'theme_support' => true,
			'version'       => '',
		];

		$method = new ReflectionMethod( $this->instance, 'set_properties' );
		$method->setAccessible( true );

		$reflection = new ReflectionClass( $this->instance );
		$property   = $reflection->getProperty( 'abt_options' );
		$property->setAccessible( true );

		$this->assertNotSame( $abt_options['locale'], $this->instance->get_locale() );

		$property->setValue( $this->instance, $abt_options );
		$method->invoke( $this->instance );

		$this->assertSame( $abt_options['locale'], $this->instance->get_locale() );
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
		$version = '1.0.0';
		$this->instance->set_version( $version )->save();

		$this->assertTrue( $this->instance->is_version( $version ) );
	}

	/**
	 * TEST: update_abt_options()
	 */
	public function test_update_abt_options(): void {
		$abt_options_without_theme_support = [
			'items'   => [],
			'locale'  => '',
			'sc'      => 0,
			'version' => '',
		];

		// @phpstan-ignore-next-line
		$abt_options = $this->instance->update_abt_options( $abt_options_without_theme_support );
		// @phpstan-ignore-next-line
		$this->assertTrue( array_key_exists( 'theme_support', $abt_options ) );
	}

	/**
	 * TEST: get_all_options()
	 *
	 * @dataProvider data_provider_test_get_all_options
	 * @param string $key_name key_name.
	 */
	public function test_get_all_options( string $key_name ): void {
		if ( is_array( $this->instance->get_all_options() ) ) {
			$this->assertTrue( array_key_exists( $key_name, $this->instance->get_all_options() ) );
		} else {
			$this->assertFalse( $this->instance->get_all_options() );
		}
	}

	/**
	 * TEST: get_get_items()
	 *
	 * @dataProvider data_provider_items_key
	 * @param string $key_name key_name.
	 */
	public function test_get_items( string $key_name ): void {
		$this->assertTrue( array_key_exists( $key_name, $this->instance->get_items() ) );
	}

	/**
	 * TEST: get_locale()
	 *
	 * @testWith [ "ja" ]
	 *           [ "en_US" ]
	 *
	 * @param string $locale_value locale_value.
	 */
	public function test_get_locale( string $locale_value ): void {
		$this->instance->set_locale( $locale_value )->save();
		$this->assertSame( $locale_value, $this->instance->get_locale() );

	}

	/**
	 * TEST: get_sc()
	 *
	 * @testWith [ 0 ]
	 *           [ 1 ]
	 *           [ 2 ]
	 *
	 * @param int $sc_value sc_value.
	 */
	public function test_get_sc( int $sc_value ): void {
		$this->instance->set_sc( $sc_value )->save();
		$this->assertSame( $sc_value, $this->instance->get_sc() );
	}

	/**
	 * TEST: get_theme_support()
	 *
	 * @testWith [ true ]
	 *           [ false ]
	 *
	 * @param bool $theme_support_value theme_support_value.
	 */
	public function test_get_theme_support( bool $theme_support_value ): void {
		$this->instance->set_theme_support( $theme_support_value )->save();
		$theme_support_value ? $this->assertTrue( $this->instance->get_theme_support() ) : $this->assertFalse( $this->instance->get_theme_support() );
	}

	/**
	 * TEST: set_items()
	 */
	public function test_set_items(): void {
		$items                  = $this->instance->get_items();
		$items['psi']['status'] = ! $items['psi']['status'];
		$this->instance->set_items( $items )->save();

		$this->assertSame( $items['psi']['status'], $this->instance->get_items()['psi']['status'] );
	}

	/**
	 * TEST: set_locale()
	 */
	public function test_set_locale(): void {
		$current_locale = get_locale();
		$this->assertSame( $current_locale, $this->instance->get_locale() );
		$this->instance->set_locale( 'ja' === $current_locale ? 'en_US' : 'ja' )->save();
		$this->assertNotSame( $current_locale, $this->instance->get_locale() );
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
		$this->instance->set_locale( 'ja' )->save();
		$this->assertSame( 'ja', $this->instance->get_locale() );

		$this->instance->set_locale( 'en_US' )->save();
		$this->assertSame( 'en_US', $this->instance->get_locale() );
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

	/**
	 * Data provider for test_get_all_options method.
	 *
	 * @return array<array<string>>
	 */
	public function data_provider_test_get_all_options(): array {
		return [
			'items'         => [ 'items' ],
			'locale'        => [ 'locale' ],
			'sc'            => [ 'sc' ],
			'theme_support' => [ 'theme_support' ],
			'version'       => [ 'version' ],
		];
	}

	/**
	 * Data provider for test_get_items method.
	 *
	 * @return array<array<string>>
	 */
	public function data_provider_items_key(): array {
		return [
			'psi'      => [ 'psi' ],
			'lh'       => [ 'lh' ],
			'gsc'      => [ 'gsc' ],
			'gc'       => [ 'gc' ],
			'gi'       => [ 'gi' ],
			'bi'       => [ 'bi' ],
			'twitter'  => [ 'twitter' ],
			'facebook' => [ 'facebook' ],
			'hatena'   => [ 'hatena' ],
		];
	}
}
