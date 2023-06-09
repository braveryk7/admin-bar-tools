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
	 *
	 * @testWith [ true ]
	 *           [ false ]
	 *
	 * @param bool $is_admin Is admin.
	 */
	public function test_deactivate( bool $is_admin ): void {
		$plugin_file = 'admin-bar-tools/admin-bar-tools.php';

		$this->assertFalse( is_plugin_active( $plugin_file ) );

		activate_plugin( $plugin_file );

		$this->assertTrue( is_plugin_active( $plugin_file ) );

		ob_start();
		$this->instance->deactivate( $plugin_file, 'Admin Bar Tools', '8.0', $is_admin );
		$actual = ob_get_clean();

		if ( $is_admin && is_string( $actual ) ) {
			$this->assertStringContainsString( '<div class="error">', $actual );
		}

		$this->assertFalse( is_plugin_active( $plugin_file ) );
	}

	/**
	 * TEST: deactivate_message()
	 */
	public function test_deactivate_message(): void {
		$plugin_name = 'Admin Bar Tools';
		$version     = '8.0';
		$message     = $this->instance->deactivate_message( $plugin_name, $version );

		$this->assertArrayHasKey( 'header', $message );
		$this->assertArrayHasKey( 'require', $message );
		$this->assertArrayHasKey( 'upgrade', $message );
		$this->assertArrayHasKey( 'current', $message );

		$this->assertSame(
			sprintf(
				/* translators: 1: Plugin name */
				__( '[Plugin error] %s has been stopped because the PHP version is old.', 'admin-bar-tools' ),
				$plugin_name,
			),
			$message['header'],
		);
		$this->assertSame(
			sprintf(
				/* translators: 1: Plugin name 2: PHP version */
				__( '%1$s requires at least PHP %2$s or later.', 'admin-bar-tools' ),
				$plugin_name,
				$version,
			),
			$message['require'],
		);
		$this->assertSame(
			__( 'Please upgrade PHP.', 'admin-bar-tools' ),
			$message['upgrade'],
		);
		$this->assertSame(
			__( 'Current PHP version:', 'admin-bar-tools' ),
			$message['current'],
		);
	}
}
