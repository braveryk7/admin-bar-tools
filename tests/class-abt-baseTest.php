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

	/**
	 * TEST: return_plugin_url()
	 */
	public function test_get_plugin_url() {
		$method = new ReflectionMethod( $this->instance, 'get_plugin_url' );
		$method->setAccessible( true );

		$this->assertSame(
			'https://example.com/wp-content/plugins/admin-bar-tools',
			$method->invoke( $this->instance ),
		);
		$this->assertSame(
			'https://example.com/wp-content/plugins/send-chat-tools',
			$method->invoke( $this->instance, 'send-chat-tools' ),
		);
	}

	/**
	 * TEST: get_plugin_dir()
	 */
	public function test_get_plugin_dir() {
		$method = new ReflectionMethod( $this->instance, 'get_plugin_dir' );
		$method->setAccessible( true );

		$this->assertSame(
			'/DocumentRoot/wp-content/plugins/admin-bar-tools',
			$method->invoke( $this->instance ),
		);
		$this->assertSame(
			'/DocumentRoot/wp-content/plugins/send-chat-tools',
			$method->invoke( $this->instance, 'send-chat-tools' ),
		);
	}
}
