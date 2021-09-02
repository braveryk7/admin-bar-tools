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
					if ( ! is_admin() ) {
						if ( 'hatena' === $value->shortname && isset( $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI'] ) ) {
							$link_url = $value->url . sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) . sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) );
						} elseif ( 'gsc' === $value->shortname ) {
							$link_url = self::searchconsole_url( $value->url, get_option( 'abt_sc' ), $url );
						} else {
							$link_url = in_array( $value->id, $join_url_lists, true ) ? $value->url . $url : $value->url;
						}
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

	/**
	 * Create Google SearchConsole URL.
	 *
	 * @param string $url           SearchConsole URL.
	 * @param string $status        Use SearchConsole type (Don't use, Domain or URL Prefix).
	 * @param string $encode_url    Use rawurlencode page url.
	 *
	 * @return string SearchConsole URL.
	 */
	private static function searchconsole_url( string $url, string $status, string $encode_url ): string {
		$domain = isset( $_SERVER['SERVER_NAME'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) ) : '';
		if ( '1' === $status ) {
			if ( is_front_page() ) {
				$parameter = '?resource_id=sc-domain:';
				$gsc_url   = $url . $parameter . $domain;
			} else {
				$parameter = '/performance/search-analytics?resource_id=sc-domain:';
				$gsc_url   = $url . $parameter . $domain . '&page=!' . $encode_url;
			}
		} elseif ( '2' === $status ) {
			if ( is_front_page() ) {
				$parameter = '?resource_id=sc-domain:';
				$gsc_url   = $url . $parameter . $encode_url;
			} else {
				$parameter = '/performance/search-analytics?resource_id=sc-domain:';
				$gsc_url   = $url . $parameter . rawurlencode( $ssl . $domain . '/' ) . '&page=!' . $encode_url;
			}
		} else {
			$gsc_url = $url;
		}

		return $gsc_url;
	}
}
