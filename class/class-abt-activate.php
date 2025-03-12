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
		add_action( 'init', [ $this, 'check_abt_options_column_exists' ], 10 );
		add_filter( 'http_request_args', [ $this, 'check_environment' ], 0, 1 );
	}

	/**
	 * For development environments (development or local), set sslverify to false.
	 *
	 * @param array $args WordPress environment variables.
	 */
	public function check_environment( $args ) {
		$args['sslverify'] = match ( wp_get_environment_type() ) {
			'development', 'local' => false,
			'production', 'staging' => true,
			default => true,
		};
		return $args;
	}

	/**
	 * Check abt_options column exists.
	 */
	public function check_abt_options_column_exists() {
		$abt_options = $this->get_abt_options();
		$this->create_items();

		if ( ! $abt_options ) {
			$this->register_options();
		}

		if ( self::VERSION !== $abt_options['version'] ) {
			foreach ( self::OPTIONS_KEY as $key_name ) {
				if ( ! array_key_exists( $key_name, $abt_options ) ) {
					if ( 'theme_support' === $key_name ) {
						$abt_options[ $key_name ] = true;
					}
				}
			}

			// v1.6.3: Delete the Google Cache key if it exists.
			if ( array_key_exists( 'gc', $abt_options['items'] ) ) {
				unset( $abt_options['items']['gc'] );
			}

			$this->set_abt_options( $abt_options );
		}
	}

	/**
	 * Register wp_options column.
	 */
	public function register_options(): void {
		if ( ! $this->get_abt_options() ) {
			$options = [
				'items'         => $this->create_items(),
				'locale'        => get_locale(),
				'sc'            => 0,
				'theme_support' => true,
				'version'       => self::VERSION,
			];

			$this->set_abt_options( $options );
		}
	}

	/**
	 * Uninstall wp_options column.
	 */
	public static function uninstall_options(): void {
		foreach ( self::OPTIONS_COLUMN as $option_name ) {
			delete_option( self::add_prefix( $option_name ) );
		}
	}

	/**
	 * Create status item value.
	 */
	private function create_items(): array {
		$items          = [];
		$current_locale = get_locale();
		$abt_options    = $this->get_abt_options();
		$psi            = 'https://developers.google.com/speed/pagespeed/insights/?hl=';

		try {
			$request = wp_remote_get( $this->get_plugin_url() . '/common/locales.json' );

			if ( 200 === wp_remote_retrieve_response_code( $request ) ) {
				$locales       = json_decode( wp_remote_retrieve_body( $request ), true );
				$psi_admin_url = array_key_exists( $current_locale, $locales ) ? $psi . $locales[ $current_locale ]['id'] : $psi . 'us';
			}
		} finally {
			$psi_url = $psi_admin_url ?? $psi . 'us';
		}

		$location_url = [
			'psi'      => [
				'url'   => $psi_url . '&url=',
				'admin' => $psi_url,
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
			$items[ $key ] = [
				'name'      => $value['name'],
				'shortname' => $key,
				'status'    => $abt_options ? $abt_options['items'][ $key ]['status'] : true,
				'url'       => $value['url'],
				'adminurl'  => $value['admin'],
				'order'     => $value['order'],
			];
		}

		return $items;
	}
}
