<?php
/**
 * Plugin activate.
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
 * Activate process.
 */
class Abt_Activate extends Abt_Base {
	/**
	 * Constructor.
	 */
	public function __construct() {
		register_activation_hook( $this->get_plugin_path(), [ $this, 'register_options' ] );
	}

	/**
	 * Register wp_options column.
	 */
	public function register_options(): void {
		$options = [
			'status'  => $this->create_abt_status(),
			'locale'  => get_locale(),
			'sc'      => 0,
			'version' => self::VERSION,
		];

		add_option( $this->add_prefix( 'options' ), $options );
	}

	/**
	 * Create status item value.
	 */
	private function create_status(): array {
		$abt_status = [];
		$locale     = get_locale();
		$psi        = 'https://developers.google.com/speed/pagespeed/insights/?hl=';

		$psi_admin_url = array_key_exists( $locale, self::PSI_LOCALES ) ? $psi . self::PSI_LOCALES[ $locale ]['id'] : $psi . 'us';
		$psi_url       = $psi_admin_url . '&url=';

		$location_url = [
			'psi'      => [
				'url'   => $psi_url,
				'admin' => $psi_admin_url,
				'name'  => __( 'PageSpeed Insights', 'admin-bar-tools' ),
				'order' => 1,
			],
			'lh'       => [
				'url'   => 'https://googlechrome.github.io/lighthouse/viewer/?psiurl=',
				'admin' => 'https://googlechrome.github.io/lighthouse/viewer/',
				'name'  => __( 'Lighthouse', 'admin-bar-tools' ),
				'order' => 2,
			],
			'gsc'      => [
				'url'   => 'https://search.google.com/search-console',
				'admin' => 'https://search.google.com/search-console',
				'name'  => __( 'Google Search Console', 'admin-bar-tools' ),
				'order' => 3,
			],
			'gc'       => [
				'url'   => 'https://webcache.googleusercontent.com/search?q=cache%3A',
				'admin' => 'https://webcache.googleusercontent.com/search?q=cache%3A',
				'name'  => __( 'Google Cache', 'admin-bar-tools' ),
				'order' => 4,
			],
			'gi'       => [
				'url'   => 'https://www.google.com/search?q=site%3A',
				'admin' => 'https://www.google.com/search?q=site%3A',
				'name'  => __( 'Google Index', 'admin-bar-tools' ),
				'order' => 5,
			],
			'bi'       => [
				'url'   => 'https://www.bing.com/search?q=url%3a',
				'admin' => 'https://www.bing.com/search?q=url%3a',
				'name'  => __( 'Bing Index', 'admin-bar-tools' ),
				'order' => 9,
			],
			'twitter'  => [
				'url'   => 'https://twitter.com/search?f=live&q=',
				'admin' => 'https://twitter.com/',
				'name'  => __( 'Twitter Search', 'admin-bar-tools' ),
				'order' => 6,
			],
			'facebook' => [
				'url'   => 'https://www.facebook.com/search/top?q=',
				'admin' => 'https://www.facebook.com/',
				'name'  => __( 'Facebook Search', 'admin-bar-tools' ),
				'order' => 7,
			],
			'hatena'   => [
				'url'   => 'https://b.hatena.ne.jp/entry/s/',
				'admin' => 'https://b.hatena.ne.jp/',
				'name'  => __( 'Hatena Bookmark', 'admin-bar-tools' ),
				'order' => 8,
			],
		];

		foreach ( $location_url as $key => $value ) {
			$abt_status[ $key ] = [
				'name'      => $value['name'],
				'shortname' => $key,
				'status'    => get_option( $this->add_prefix( 'status' ) ) ? $this->get_abt_status( $key ) : true,
				'url'       => $value['url'],
				'adminurl'  => $value['admin'],
				'order'     => $value['order'],
			];
		}

		return $abt_status;
	}
}
