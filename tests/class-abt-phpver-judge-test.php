<?php
declare( strict_types = 1 );

use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * Test: Abt_Phpver_Judge
 */
class Abt_Phpver_Judge_Test extends TestCase {
	/**
	 * This test class instance.
	 *
	 * @var Abt_Phpver_Judge $instance instance.
	 */
	private $instance;

	/**
	 * Methods to process before testing.
	 */
	public static function set_up_before_class(): void {
		require_once ROOT_DIR . '/class/class-abt-phpver-judge.php';
	}

	/**
	 * SetUp.
	 * Create instance.
	 */
	public function set_up() :void {
		parent::set_up();
		$this->instance = new Abt_Phpver_Judge();
	}

	/**
	 * TEST: judgment()
	 */
	public function test_judgment(): void {
		$require_php_version = '8.0.0';
		$this->assertTrue( $this->instance->judgment( $require_php_version ) );

		$unrealistic_php_version = '100.0';
		$this->assertFalse( $this->instance->judgment( $unrealistic_php_version ) );
	}

	/**
	 * TEST: deactivate()
	 */
	public function test_deactivate(): void {
		$this->markTestIncomplete( 'This test is incomplete.' );
	}

	/**
	 * TEST: deactivate_message()
	 */
	public function test_deactivate_message(): void {
		$this->markTestIncomplete( 'This test is incomplete.' );
	}
}
