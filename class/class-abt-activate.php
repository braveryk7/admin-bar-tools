<?php
/**
 * File that defines the class Abt_Activate for the process to be executed during activation and uninstallation.
 *
 * @author     Ken-chan
 * @package    WordPress
 * @subpackage Admin Bar Tools
 * @since      1.5.0
 */

declare( strict_types = 1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'You do not have access rights.' );
}

/**
 * Class for the process to be executed when a plugin is activated or uninstalled.
 *
 * @phpstan-import-type abt_options_items_types from Abt_Options
 */
class Abt_Activate extends Abt_Base {
	/**
	 * Abt_Options instance.
	 *
	 * @var Abt_Options $abt_options instance
	 */
	private $abt_options;

	/**
	 * Constructor.
	 *
	 * @param Abt_Options $abt_options Abt_Options instance.
	 */
	public function __construct( Abt_Options $abt_options ) {
		$this->abt_options = $abt_options;

		register_activation_hook( $this->get_plugin_path(), [ $abt_options, 'register_options' ] );
		add_filter( 'http_request_args', [ $this, 'check_environment' ], 0, 1 );
	}

	/**
	 * For development environments (development or local), set sslverify to false.
	 *
	 * @param array<string,mixed> $args             WordPress environment variables.
	 * @param string|null         $environment_type WordPress environment type.
	 *
	 * @return array<string,mixed> $args
	 */
	public function check_environment( array $args, ?string $environment_type = null ): array {
		$args['sslverify'] = match ( $environment_type ?? wp_get_environment_type() ) {
			'development', 'local' => false,
			'production', 'staging' => true,
			default => true,
		};
		return $args;
	}

	/**
	 * Uninstall wp_options column.
	 */
	public static function uninstall_options(): void {
		foreach ( self::OPTIONS_COLUMN as $option_name ) {
			delete_option( self::add_prefix( $option_name ) );
		}
	}
}
