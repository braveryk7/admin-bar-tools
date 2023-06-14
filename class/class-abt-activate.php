<?php
/**
 * File that defines the class Abt_Activate for the process to be executed during activation and uninstallation.
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
 * Class for the process to be executed when a plugin is activated or uninstalled.
 *
 * @phpstan-import-type abt_options_items_types from Abt_Options
 */
class Abt_Activate extends Abt_Base {
	/**
	 * Abt_Options instance.
	 *
	 * @var Abt_Options $abt_options instance
	 */
	private $abt_options;

	/**
	 * Constructor.
	 *
	 * @param Abt_Options $abt_options Abt_Options instance.
	 */
	public function __construct( Abt_Options $abt_options ) {
		$this->abt_options = $abt_options;

		register_activation_hook( $this->get_plugin_path(), [ $this, 'register_options' ] );
		add_action( 'init', [ $this, 'update_abt_options' ], 10 );
		add_filter( 'http_request_args', [ $this, 'check_environment' ], 0, 1 );
	}

	/**
	 * For development environments (development or local), set sslverify to false.
	 *
	 * @param array<string,mixed> $args             WordPress environment variables.
	 * @param string|null         $environment_type WordPress environment type.
	 *
	 * @return array<string,mixed> $args
	 */
	public function check_environment( array $args, ?string $environment_type = null ): array {
		$args['sslverify'] = match ( $environment_type ?? wp_get_environment_type() ) {
			'development', 'local' => false,
			'production', 'staging' => true,
			default => true,
		};
		return $args;
	}

	/**
	 * Method to add missing items to abt_options.
	 */
	public function update_abt_options(): void {
		$abt_options = $this->get_abt_options();

		if ( ! $abt_options ) {
			$this->register_options();
		} elseif ( isset( $abt_options['version'] ) && is_string( $abt_options['version'] ) && $this->is_abt_version( $abt_options['version'] ) ) {
			foreach ( self::OPTIONS_KEY as $key_name ) {
				if ( ! array_key_exists( $key_name, $abt_options ) ) {
					if ( 'theme_support' === $key_name ) {
						$abt_options[ $key_name ] = true;
					}
				}
			}

			$this->set_abt_options( $abt_options );
		}
	}

	/**
	 * Method that compares the VERSION of abt_options with the VERSION value of Abt_Base.
	 *
	 * @param string $abt_options_version abt_options version.
	 */
	private function is_abt_version( string $abt_options_version ): bool {
		return $this->get_version() === $abt_options_version ? true : false;
	}

	/**
	 * Register wp_options column.
	 */
	public function register_options(): void {
		if ( ! $this->get_abt_options() ) {
			$this->abt_options
				->set_items( $this->create_items() )
				->set_locale( get_locale() )
				->set_sc( 0 )
				->set_theme_support( true )
				->set_version( $this->get_version() )
				->save();
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
	 * Generate status item value.
	 *
	 * @phpstan-return abt_options_items_types
	 * @return array
	 */
	private function create_items(): array {
		$items          = [];
		$current_locale = get_locale();
		$psi            = 'https://developers.google.com/speed/pagespeed/insights/?hl=';

		try {
			require_once ABSPATH . 'wp-admin/includes/file.php';

			if ( WP_Filesystem() ) {
				global $wp_filesystem;

				$locales       = $wp_filesystem->get_contents( $this->get_plugin_dir() . '/common/locales.json' );
				$psi_admin_url = $psi . json_decode( $locales )->$current_locale->id;
			} else {
				$request = wp_remote_get( $this->get_plugin_url() . '/common/locales.json' );

				if ( 200 === wp_remote_retrieve_response_code( $request ) ) {
					$locales = json_decode( wp_remote_retrieve_body( $request ), true );

					if ( is_array( $locales ) && array_key_exists( $current_locale, $locales ) && is_array( $locales[ $current_locale ] ) ) {
						$psi_admin_url = array_key_exists( $current_locale, $locales )
							? $psi . $locales[ $current_locale ]['id']
							: $psi . 'us';
					}
				}
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
			$items[ $key ] = [
				'name'      => $value['name'],
				'shortname' => $key,
				'status'    => $this->abt_options->is_abt_options_exists() ? $this->abt_options->get_items()[ $key ]['status'] : true,
				'url'       => $value['url'],
				'adminurl'  => $value['admin'],
				'order'     => $value['order'],
			];
		}

		return $items;
	}
}
