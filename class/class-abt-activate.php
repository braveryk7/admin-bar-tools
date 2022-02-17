<?php
/**
 * Plugin activate.
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
 * Activate process.
 */
class Abt_Activate extends Abt_Base {
	/**
	 * Constructor.
	 */
	public function __construct() {
		register_activation_hook( $this->get_plugin_path(), [ $this, 'register_options' ] );
	}

	/**
	 * Register wp_options column.
	 */
	public function register_options(): void {
		$options = [
			'status'  => $this->create_abt_status(),
			'locale'  => get_locale(),
			'sc'      => 0,
			'version' => self::VERSION,
		];

		add_option( $this->add_prefix( 'options' ), $options );
	}
}
