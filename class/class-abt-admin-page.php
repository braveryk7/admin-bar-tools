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
	 *
	 * @param string $path admin-bar-tools.php path.
	 */
	public function __construct( string $path ) {
		add_action( 'admin_menu', [ $this, 'add_menu' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'add_scripts' ] );
		add_action( 'rest_api_init', [ $this, 'register' ] );
		add_filter( 'plugin_action_links_' . plugin_basename( $path ), [ $this, 'add_settings_links' ] );
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
	 * Add configuration link to plugin page.
	 *
	 * @param array|string $links plugin page setting links.
	 */
	public function add_settings_links( array $links ): array {
		$add_link = '<a href="options-general.php?page=admin-bar-tools-settings">' . __( 'Settings', 'admin-bar-tools' ) . '</a>';
		array_unshift( $links, $add_link );
		return $links;
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
	 * Set register.
	 */
	public function register() {
		$array_item = [
			'type'       => 'object',
			'properties' => [
				'name'      => [ 'type' => 'string' ],
				'shortname' => [ 'type' => 'string' ],
				'status'    => [ 'type' => 'boolean' ],
				'url'       => [ 'type' => 'string' ],
				'adminurl'  => [ 'type' => 'string' ],
			],
		];
		register_setting(
			'admin-bar-tools-settings',
			'abt_status',
			[
				'show_in_rest' => [
					'schema' => [
						'type'       => 'object',
						'properties' => [
							'psi'      => $array_item,
							'lh'       => $array_item,
							'gsc'      => $array_item,
							'gc'       => $array_item,
							'gi'       => $array_item,
							'twitter'  => $array_item,
							'facebook' => $array_item,
							'hatena'   => $array_item,
							'bi'       => $array_item,
						],
					],
				],
			]
		);

		register_setting(
			'admin-bar-tools-settings',
			'abt_sc',
			[
				'type'         => 'number',
				'show_in_rest' => true,
				'default'      => get_option( 'abt_sc' ),
			],
		);
	}

	/**
	 * Settings page.
	 */
	public function abt_settings() {
		echo '<div id="admin-bar-tools-settings"></div>';
	}
}
