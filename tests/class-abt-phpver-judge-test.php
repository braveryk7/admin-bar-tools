<?php
declare( strict_types = 1 );

use Yoast\WPTestUtils\WPIntegration\TestCase;

/**
 * Test: Abt_Activate
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
}
