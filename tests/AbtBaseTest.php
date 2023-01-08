<?php
declare( strict_types = 1 );

/**
 * Test: Sct_Base
 */
class AbtBaseTest extends PHPUnit\Framework\TestCase {
	/**
	 * This test class instance.
	 *
	 * @var object $instance instance.
	 */
	private $instance;

	/**
	 * Settings: ABSPATH, test class file, WordPress functions.
	 */
	public static function setUpBeforeClass(): void {
		if ( ! defined( 'ABSPATH' ) ) {
			define( 'ABSPATH', '' );
		}

		require_once './class/class-abt-base.php';
		require_once './tests/lib/wordpress-functions.php';
	}

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
	 * TEST: get_plugin_name()
	 */
	public function test_get_plugin_name() {
		$this->assertSame( 'Admin Bar Tools', $this->instance->get_plugin_name() );
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

	/**
	 * TEST: get_plugin_path()
	 */
	public function test_get_plugin_path() {
		$method = new ReflectionMethod( $this->instance, 'get_plugin_path' );
		$method->setAccessible( true );

		$this->assertSame(
			'/DocumentRoot/wp-content/plugins/admin-bar-tools/admin-bar-tools.php',
			$method->invoke( $this->instance )
		);
		$this->assertSame(
			'/DocumentRoot/wp-content/plugins/admin-bar-tools/admin-bar-tools.php',
			$method->invoke( $this->instance, 'admin-bar-tools', 'admin-bar-tools.php' ),
		);
	}

	/**
	 * TEST: get_option_group()
	 */
	public function test_get_option_group() {
		$method = new ReflectionMethod( $this->instance, 'get_option_group' );
		$method->setAccessible( true );

		$this->assertSame(
			'admin-bar-tools-settings',
			$method->invoke( $this->instance )
		);
	}

	/**
	 * TEST: get_abt_options()
	 */
	public function test_get_abt_options() {
		$this->markTestIncomplete( 'This test is incomplete.' );
	}

	/**
	 * TEST: set_abt_options()
	 */
	public function test_set_abt_options() {
		$this->markTestIncomplete( 'This test is incomplete.' );
	}

	/**
	 * TEST: get_required_php_version()
	 *
	 * @test
	 * @testWith [ "7.4.0" ]
	 *           [ "8" ]
	 *           [ "8.1" ]
	 *           [ "8.1.5" ]
	 *
	 * @param string $version PHP version.
	 */
	public function test_get_required_php_version( $version ) {
		$pattern = '/^[0-9]+\.?[0-9]?+\.?[0-9]?+\.?/';

		$this->assertMatchesRegularExpression( $pattern, $version );

		// Current version.
		$this->assertMatchesRegularExpression( $pattern, Abt_Base::get_required_php_version() );
	}

	/**
	 * TEST: console()
	 */
	public function test_console() {
		$this->markTestIncomplete( 'This test is incomplete.' );
	}
}