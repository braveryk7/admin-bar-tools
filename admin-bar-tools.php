<?php
/**
 * Plugin Name: Admin Bar Tools
 * Plugin URI: https://www.braveryk7.com/
 * Description: A plugin that allows you to add useful links to the admin bar.
 * Version: 1.0.3
 * Author: Ken-chan
 * Author URI: https://twitter.com/braveryk7
 * Text Domain: admin-bar-tools
 * Domain Path: /languages
 * License: GPL2
 *
 * @author Ken-chan
 * @package WordPress
 * @subpackage Admin Bar Tools
 * @since 0.0.1
 */

declare( strict_types = 1 );

load_plugin_textdomain( 'admin-bar-tools', false, basename( dirname( __FILE__ ) ) . '/languages' );

require_once dirname( __FILE__ ) . '/class/class-judgment-php-version.php';

$require_php_version  = '7.3.0';
$get_php_version_bool = new Judgment_Php_Version();
if ( false === $get_php_version_bool->judgment( $require_php_version ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
	if ( is_plugin_active( plugin_basename( __FILE__ ) ) ) {
		require_once dirname( __FILE__ ) . '/modules/cancel-activate.php';
		if ( is_admin() ) {
			cancel_activate();
		}
		deactivate_plugins( plugin_basename( __FILE__ ) );
	} else {
		echo '<p>' . esc_html_e( 'Admin Bar Tools requires at least PHP 7.3.0 or later.' ) . esc_html_e( 'Please upgrade PHP.' ) . '</p>';
		exit;
	}
} elseif ( true === $get_php_version_bool->judgment( $require_php_version ) ) {
	require_once dirname( __FILE__ ) . '/class/class-abt-return-data.php';
	require_once dirname( __FILE__ ) . '/class/class-abt-admin-settings-page.php';
	require_once dirname( __FILE__ ) . '/class/class-abt-connect-database.php';

	/**
	 * Activation Hook.
	 */
	function abt_activate() {
		$db_class = new Abt_Connect_Database();
		register_activation_hook( __FILE__, [ $db_class, 'abt_search_table' ] );
		register_activation_hook( __FILE__, [ $db_class, 'abt_default_insert_db' ] );
	};
	abt_activate();

	/**
	 * Uninstall Hook.
	 */
	function abt_uninstall() {
		$db_class = new Abt_Connect_Database();
		register_uninstall_hook( __FILE__, [ $db_class, 'abt_delete_db' ] );
	}
	abt_uninstall();

	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'Abt_Admin_Settings_Page::add_settings_links' );


	/**
	 * Insert Admin bar
	 *
	 * @param object $wp_admin_bar Admin bar.
	 */
	function abt_add_adminbar( object $wp_admin_bar ) {
		$url            = rawurlencode( get_pagenum_link( get_query_var( 'paged' ) ) );
		$join_url_lists = [ '1001', '1002', '2002', '2003', '3001', '3002' ];

		$wp_admin_bar->add_node(
			[
				'id'    => 'abt',
				'title' => __( 'Admin Bar Tools', 'admin-bar-tools' ),
				'meta'  => [
					'target' => 'abt',
				],
			]
		);

		$db_call = new Abt_Connect_Database();
		$result  = $db_call->return_table_data( Abt_Return_Data::TABLE_NAME );

		foreach ( $result as $key => $value ) {
			if ( '1' === $value->status ) {
				if ( ! is_admin() && '3003' === $value->id && isset( $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI'] ) ) {
					$link_url = $value->url . sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) . sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) );
				} elseif ( ! is_admin() ) {
					$link_url = in_array( $value->id, $join_url_lists, true ) ? $value->url . $url : $value->url;
				} elseif ( is_admin() ) {
					$link_url = $value->adminurl;
				};
				$wp_admin_bar->add_node(
					[
						'id'     => $value->shortname,
						'title'  => $value->name,
						'parent' => 'abt',
						'href'   => $link_url,
						'meta'   => [
							'target' => '_blank',
						],
					]
				);
			};
		};
	}

	add_action( 'admin_bar_menu', 'abt_add_adminbar', 999 );
}
