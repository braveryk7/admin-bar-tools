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
	 * WordPress hook.
	 */
	public function __construct() {
		add_action( 'admin_bar_menu', [ $this, 'add_admin_bar' ], 999 );
	}
	/**
	 * Insert Admin bar
	 *
	 * @param object $wp_admin_bar Admin bar.
	 */
	public function add_admin_bar( object $wp_admin_bar ) {
		$url             = rawurlencode( get_pagenum_link( get_query_var( 'paged' ) ) );
		$add_url_lists   = [ 'psi', 'lh', 'gc', 'gi', 'bi', 'twitter', 'facebook' ];
		$sanitize_domain = isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : '';
		$sanitize_uri    = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';

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

			$result = get_option( 'abt_status' );

			foreach ( $result as $items ) {
				if ( $items['status'] ) {
					if ( is_admin() ) {
						$link_url = $items['adminurl'];
					} elseif ( ! is_admin() ) {
						if ( 'hatena' === $items['shortname'] ) {
							$link_url = $items['url'] . $sanitize_domain . $sanitize_uri;
						} elseif ( 'gsc' === $items['shortname'] ) {
							$link_url = self::searchconsole_url( $items['url'], get_option( 'abt_sc' ), $url );
						} else {
							$link_url = in_array( $items['shortname'], $add_url_lists, true ) ? $items['url'] . $url : $items['url'];
						}
					}
					$wp_admin_bar->add_node(
						[
							'id'     => $items['shortname'],
							'title'  => $items['name'],
							'parent' => 'abt',
							'href'   => $link_url,
							'meta'   => [
								'target' => '_blank',
							],
						],
					);
				}
			}
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
	private function searchconsole_url( string $url, string $status, string $encode_url ): string {
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
