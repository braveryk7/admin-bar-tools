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
 */

load_plugin_textdomain( 'admin-bar-tools', false, basename( dirname( __FILE__ ) ) . '/languages' );

require_once dirname( __FILE__ ) . '/modules/abt_admin.php';
require_once dirname( __FILE__ ) . '/modules/abt_db.php';

register_activation_hook( __FILE__, 'abt_create_db' );
register_activation_hook( __FILE__, 'abt_default_insert_db' );

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'AdminSettings::add_settings_links' );

register_uninstall_hook( __FILE__, 'abt_delete_db' );

/**
 * Declare a constant
 */
class Constant {
	const TABLE_NAME = 'abt';
	const DB_VERSION = '1.0';

	/**
	 * Constant
	 *
	 * 
	 */
	private static $locale;
	private static $abt_locale;
	private $psi_url;
	private $psi_admin_url;
	public static $location_url = [];
	public static $insert_data  = [];

	/**
	 * CONSTRUCT!!
	 */
	private function __construct() {
		self::$locale     = get_locale();
		self::$abt_locale = get_option( 'abt_locale' );
		if ( 'ja' === self::$locale ) {
			$this->psi_url       = 'https://developers.google.com/speed/pagespeed/insights/?hl=JA&url=';
			$this->psi_admin_url = 'https://developers.google.com/speed/pagespeed/insights/?hl=JA';
		} else {
			$this->psi_url       = 'https://developers.google.com/speed/pagespeed/insights/?hl=US&url=';
			$this->psi_admin_url = 'https://developers.google.com/speed/pagespeed/insights/?hl=US';
		}

		self::$location_url += [
			'psi'           => $this->psi_url,
			'psiAdmin'      => $this->psi_admin_url,
			'lh'            => 'https://googlechrome.github.io/lighthouse/viewer/?psiurl=',
			'lhAdmin'       => 'https://googlechrome.github.io/lighthouse/viewer/',
			'gsc'           => 'https://search.google.com/search-console',
			'gscAdmin'      => 'https://search.google.com/search-console',
			'gc'            => 'https://webcache.googleusercontent.com/search?q=cache%3A',
			'gcAdmin'       => 'https://webcache.googleusercontent.com/search?q=cache%3A',
			'gi'            => 'https://www.google.com/search?q=site%3A',
			'giAdmin'       => 'https://www.google.com/search?q=site%3A',
			'twitter'       => 'https://twitter.com/search?f=live&q=',
			'twitterAdmin'  => 'https://twitter.com/',
			'facebook'      => 'https://www.facebook.com/search/top?q=',
			'facebookAdmin' => 'https://www.facebook.com/',
			'hatena'        => 'https://b.hatena.ne.jp/entry/s/',
			'hatenaAdmin'   => 'https://b.hatena.ne.jp/',
		];

		self::$insert_data += [
			1 => [
				'id'        => 1001,
				'shortname' => 'psi',
				'name'      => __( 'PageSpeed Insights', 'admin-bar-tools' ),
				'status'    => 1,
				'url'       => self::$location_url['psi'],
				'adminurl'  => self::$location_url['psiAdmin'],
			],
			2 => [
				'id'        => 1002,
				'shortname' => 'lh',
				'name'      => __( 'Lighthouse', 'admin-bar-tools' ),
				'status'    => 1,
				'url'       => self::$location_url['lh'],
				'adminurl'  => self::$location_url['lhAdmin'],
			],
			3 => [
				'id'        => 2001,
				'shortname' => 'gsc',
				'name'      => __( 'Google Search Console', 'admin-bar-tools' ),
				'status'    => 1,
				'url'       => self::$location_url['gsc'],
				'adminurl'  => self::$location_url['gscAdmin'],
			],
			4 => [
				'id'        => 2002,
				'shortname' => 'gc',
				'name'      => __( 'Google Cache', 'admin-bar-tools' ),
				'status'    => 1,
				'url'       => self::$location_url['gc'],
				'adminurl'  => self::$location_url['gcAdmin'],
			],
			5 => [
				'id'        => 2003,
				'shortname' => 'gi',
				'name'      => __( 'Google Index', 'admin-bar-tools' ),
				'status'    => 1,
				'url'       => self::$location_url['gi'],
				'adminurl'  => self::$location_url['giAdmin'],
			],
			6 => [
				'id'        => 3001,
				'shortname' => 'twitter',
				'name'      => __( 'Twitter Search', 'admin-bar-tools' ),
				'status'    => 1,
				'url'       => self::$location_url['twitter'],
				'adminurl'  => self::$location_url['twitterAdmin'],
			],
			7 => [
				'id'        => 3002,
				'shortname' => 'facebook',
				'name'      => __( 'Facebook Search', 'admin-bar-tools' ),
				'status'    => 1,
				'url'       => self::$location_url['facebook'],
				'adminurl'  => self::$location_url['facebookAdmin'],
			],
			8 => [
				'id'        => 3003,
				'shortname' => 'hatena',
				'name'      => __( 'Hatena Bookmark', 'admin-bar-tools' ),
				'status'    => 1,
				'url'       => self::$location_url['hatena'],
				'adminurl'  => self::$location_url['hatenaAdmin'],
			],
		];
	}

	/**
	 * Make table data
	 */
	public static function make_table_data() {
		new self();
		return self::$insert_data;
	}

	/**
	 * Change the locale on the settings page
	 *
	 * @param string $new_locale locale code.
	 */
	public static function change_locale( $new_locale ) {
		new self();
		if ( 'ja' === $new_locale ) {
			self::$insert_data['1']['url']      = 'https://developers.google.com/speed/pagespeed/insights/?hl=JA&url=';
			self::$insert_data['1']['adminurl'] = 'https://developers.google.com/speed/pagespeed/insights/?hl=JA';
		} elseif ( 'en_US' === $new_locale ) {
			self::$insert_data['1']['url']      = 'https://developers.google.com/speed/pagespeed/insights/?hl=US&url=';
			self::$insert_data['1']['adminurl'] = 'https://developers.google.com/speed/pagespeed/insights/?hl=US';
		}
		return self::$insert_data;
	}
}

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
	$table_name = $wpdb->prefix . Constant::TABLE_NAME;

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
