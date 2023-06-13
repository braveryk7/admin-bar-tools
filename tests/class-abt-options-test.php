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
	 * TEST: is_abt_options_exists()
	 */
	public function test_is_abt_options_exists(): void {
		$this->assertTrue( $this->instance->is_abt_options_exists() );

		delete_option( 'abt_options' );
		$this->assertFalse( ( new Abt_Options() )->is_abt_options_exists() );
	}
}
