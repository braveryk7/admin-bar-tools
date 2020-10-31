<?php
/**
 * Plugin Name: Admin Bar Tools
 * Plugin URI: https://www.braveryk7.com/
 * Description: Use the admin bar conveniently.
 * Version: 0.1
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

load_plugin_textdomain( 'admin-bar-tools', false, basename( dirname( __FILE__ ) ) . '/languages' );

require_once dirname( __FILE__ ) . '/class/class-abt-return-data.php';
require_once dirname( __FILE__ ) . '/modules/abt-admin.php';
require_once dirname( __FILE__ ) . '/modules/abt-db.php';

register_activation_hook( __FILE__, 'abt_create_db' );
register_activation_hook( __FILE__, 'abt_default_insert_db' );

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'AdminSettings::add_settings_links' );

register_uninstall_hook( __FILE__, 'abt_delete_db' );

/**
 * Insert Admin bar
 *
 * @param array $wp_admin_bar Admin bar.
 */
function abt_add_adminbar( $wp_admin_bar ) {
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

	global $wpdb;
	$table_name = $wpdb->prefix . Abt_Return_Data::TABLE_NAME;

	$result = $wpdb->get_results( "SELECT * FROM $table_name" );

	foreach ( $result as $key => $value ) {
		if ( '1' === $value->status ) {
			if ( ! is_admin() && '3003' === $value->id && isset( $_SERVER['HTTP_HOST'] ) && isset( $_SERVER['REQUEST_URI'] ) ) {
				$link_url = $value->url . sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) . sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) );
			} elseif ( ! is_admin() ) {
				$link_url = in_array( $value->id, $join_url_lists, true ) ? $value->url . $url : $value->url;
			} elseif ( is_admin() ) {
				$link_url = $value->adminurl;
			};
			$wp_admin_bar->add_node(
				[
					'id'     => $value->shortname,
					'title'  => __( $value->name, 'admin-bar-tools' ),
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