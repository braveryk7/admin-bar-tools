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
	 * SetUp.
	 * Create instance.
	 */
	public function set_up() :void {
		parent::set_up();
		$this->instance = Abt_Options::get_instance();
	}
}
