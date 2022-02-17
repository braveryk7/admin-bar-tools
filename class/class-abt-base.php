<?php
/**
 * Admin Bar Tools base class.
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
 * Send Chat Tools base class.
 */
class Abt_Base {
	protected const PREFIX      = 'abt';
	protected const PLUGIN_SLUG = 'admin-bar-tools';
	protected const PLUGIN_NAME = 'Admin Bar Tools';
	protected const PLUGIN_FILE = self::PLUGIN_SLUG . '.php';
	protected const TABLE_NAME  = self::PREFIX;

	/**
	 * Return add prefix.
	 *
	 * @param string $value After prefix value.
	 */
	public static function add_prefix( string $value ): string {
		return self::PREFIX . '_' . $value;
	}

	/**
	 * Return plugin url.
	 * e.g. https://expamle.com/wp-content/plugins/admin-bar-tools
	 *
	 * @param string $plugin_name Plugin name.
	 */
	protected function get_plugin_url( string $plugin_name ): string {
		return WP_PLUGIN_URL . '/' . $plugin_name;
	}

	/**
	 * Output browser console.
	 * WARNING: Use debag only!
	 *
	 * @param string|int|float|boolean|array|object $value Output data.
	 */
	protected function console( $value ): void {
		echo '<script>console.log(' . wp_json_encode( $value ) . ');</script>';
	}
}
