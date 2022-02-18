<?php
declare( strict_types = 1 );

define( 'ABSPATH', '' );

require_once './class/class-abt-base.php';

/**
 * Test: Sct_Base
 */
class Abt_BaseTest extends PHPUnit\Framework\TestCase {
	/**
	 * This test class instance.
	 *
	 * @var object $instance instance.
	 */
	private $instance;

	/**
	 * SetUp.
	 * Create instance.
	 */
	protected function setUp() :void {
		$this->instance = new Abt_Base();
	}

	/**
	 * TEST: add_prefix()
	 */
	public function test_add_prefix() {
		$this->assertSame( 'abt_options', $this->instance->add_prefix( 'options' ) );
	}
}
