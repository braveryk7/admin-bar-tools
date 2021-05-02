<?php
/**
 * Returns data class
 *
 * @author Ken-chan
 * @package WordPress
 * @subpackage Admin Bar Tools
 * @since 1.0.6
 */

declare( strict_types = 1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'You do not have access rights.' );
}

/**
 * Add Admin Bar Tools to admin bar.
 */
class Abt_Add_Admin_Bar {
	/**
	 * Insert Admin bar
	 *
	 * @param object $wp_admin_bar Admin bar.
	 */
	public static function add_admin_bar( object $wp_admin_bar ) {
		$url            = rawurlencode( get_pagenum_link( get_query_var( 'paged' ) ) );
		$join_url_lists = [ '1001', '1002', '2002', '2003', '2011', '3001', '3002' ];

		if ( true === is_user_logged_in() ) {
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
	}
}
