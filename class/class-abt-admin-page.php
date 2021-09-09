<?php
/**
 * Admin page.
 *
 * @author Ken-chan
 * @package WordPress
 * @subpackage Admin Bar Tools
 * @since 1.4.0
 */

declare( strict_types = 1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'You do not have access rights.' );
}

/**
 * Admin page.
 */
class Abt_Admin_Page {
	/**
	 * WordPress hook.
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'add_menu' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'add_scripts' ] );
	}

	/**
	 * Add WordPress menu.
	 */
	public function add_menu() {
		add_options_page(
			'Admin Bar Tools',
			'Admin Bar Tools',
			'administrator',
			'admin-bar-tools',
			[ $this, 'abt_settings' ]
		);
	}

	/**
	 * Enqueue scripts.
	 *
	 * @param string $hook_shuffix WordPress hook_shuffix.
	 */
	public function add_scripts( string $hook_shuffix ) {
		if ( 'settings_page_admin-bar-tools' !== $hook_shuffix ) {
			return;
		}

		$asset_file = require_once WP_PLUGIN_DIR . '/admin-bar-tools/build/index.asset.php';

		wp_enqueue_style(
			'admin-bar-tools-settings-style',
			WP_PLUGIN_URL . '/admin-bar-tools/build/index.css',
			[ 'wp-components' ],
			$asset_file['version'],
		);

		wp_enqueue_script(
			'admin-bar-tools-settings-script',
			WP_PLUGIN_URL . '/admin-bar-tools/build/index.js',
			$asset_file['dependencies'],
			$asset_file['version'],
			true
		);
	}

	/**
	 * Settings page.
	 */
	public function abt_settings() {
		echo '<div id="admin-bar-tools-settings"></div>';
	}
}
