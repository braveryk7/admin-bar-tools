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
class Abt_Admin_Page extends Abt_Base {
	/**
	 * WordPress hook.
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'add_menu' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'add_scripts' ] );
		add_filter( 'plugin_action_links_' . plugin_basename( $this->get_plugin_path() ), [ $this, 'add_settings_links' ] );
		add_action( 'rest_api_init', [ $this, 'register_rest_api' ] );
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
			[ $this, $this->add_prefix( 'settings' ) ]
		);
	}

	/**
	 * Add configuration link to plugin page.
	 *
	 * @param array|string $links plugin page setting links.
	 */
	public function add_settings_links( array $links ): array {
		$add_link = '<a href="options-general.php?page=' . self::PLUGIN_SLUG . '">' . __( 'Settings', 'admin-bar-tools' ) . '</a>';
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

		$asset_file = require_once $this->get_plugin_dir() . '/build/index.asset.php';

		wp_enqueue_style(
			$this->add_prefix( 'style' ),
			$this->get_plugin_url() . '/build/index.css',
			[ 'wp-components' ],
			$asset_file['version'],
		);

		wp_enqueue_script(
			$this->add_prefix( 'script' ),
			$this->get_plugin_url() . '/build/index.js',
			$asset_file['dependencies'],
			$asset_file['version'],
			true
		);

		wp_set_script_translations(
			$this->add_prefix( 'script' ),
			self::PLUGIN_SLUG,
			$this->get_plugin_dir() . '/languages/js',
		);
	}

	/**
	 * Create custom endpoint.
	 */
	public function register_rest_api() {
		register_rest_route(
			'admin-bar-tools/v1',
			'/options',
			[
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => [ $this, 'readable_api' ],
				'permission_callback' => [ $this, 'get_wordpress_permission' ],
			]
		);

		register_rest_route(
			'admin-bar-tools/v1',
			'/update',
			[
				'methods'             => WP_REST_Server::EDITABLE,
				'callback'            => [ $this, 'update_options' ],
				'permission_callback' => [ $this, 'get_wordpress_permission' ],
			]
		);
	}

	/**
	 * Return WordPress  administrator permission.
	 */
	public function get_wordpress_permission(): bool {
		return current_user_can( 'administrator' );
	}

	/**
	 * Custom endpoint for read.
	 */
	public function readable_api() {
		$abt_options = get_option( 'abt_options' );
		return new WP_REST_Response( $abt_options, 200 );
	}

	/**
	 * Settings page.
	 */
	public function abt_settings() {
		echo '<div id="' . esc_attr( $this->get_option_group() ) . '"></div>';
	}
}
