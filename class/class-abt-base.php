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
	protected const PREFIX              = 'abt';
	protected const PLUGIN_SLUG         = 'admin-bar-tools';
	protected const PLUGIN_NAME         = 'Admin Bar Tools';
	protected const PLUGIN_FILE         = self::PLUGIN_SLUG . '.php';
	private const API_NAME              = self::PLUGIN_SLUG;
	private const API_VERSION           = 'v1';
	private const VERSION               = '1.6.2';
	protected const OPTIONS_COLUMN_NAME = 'options';

	public const OPTIONS_COLUMN = [
		'options',
	];

	protected const OPTIONS_KEY = [
		'items',
		'locale',
		'sc',
		'theme_support',
		'version',
	];

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
	protected function get_plugin_url( string $plugin_name = self::PLUGIN_SLUG ): string {
		return content_url( 'plugins/' . $plugin_name );
	}

	/**
	 * Return plugin name.
	 * e.g. Admin Bar Tools
	 */
	public static function get_plugin_name(): string {
		return self::PLUGIN_NAME;
	}

	/**
	 * Return plugin directory.
	 * e.g. /DocumentRoot/wp-content/plugins/admin-bar-tools
	 *
	 * @param string $plugin_slug Plugin slug.
	 */
	protected function get_plugin_dir( string $plugin_slug = self::PLUGIN_SLUG ): string {
		return dirname( plugin_dir_path( __FILE__ ), 2 ) . '/' . $plugin_slug;
	}

	/**
	 * Return plugin file path.
	 * e.g. /DocumentRoot/wp-content/plugins/send-chat-tools/admin-bar-tools.php
	 *
	 * @param string $plugin_slug Plugin slug. e.g. send-chat-tools .
	 * @param string $plugin_file Plugin file. e.g. send-chat-tools.php .
	 */
	protected function get_plugin_path( string $plugin_slug = self::PLUGIN_SLUG, string $plugin_file = self::PLUGIN_FILE ): string {
		return $this->get_plugin_dir( $plugin_slug ) . '/' . $plugin_file;
	}

	/**
	 * Return WP-API parameter.
	 * e.g. admin-bar-tools/v1
	 *
	 * @param string $api_name    Plugin unique name.
	 * @param string $api_version Plugin API version.
	 */
	protected function get_api_namespace( string $api_name = self::API_NAME, string $api_version = self::API_VERSION ): string {
		return "{$api_name}/{$api_version}";
	}

	/**
	 * Return VERSION constant.
	 * e.g. 1.6.2
	 */
	protected function get_version(): string {
		return self::VERSION;
	}

	/**
	 * Return option group.
	 * Use register_setting.
	 * e.g. admin-bar-tools-settings
	 */
	protected function get_option_group(): string {
		return self::PLUGIN_SLUG . '-settings';
	}

	/**
	 * Output browser console.
	 * WARNING: Use debag only!
	 *
	 * @param mixed $value Output data.
	 */
	protected function console( mixed $value ): void {
		echo '<script>console.log(' . wp_json_encode( $value ) . ');</script>';
	}
}
