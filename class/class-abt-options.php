<?php
/**
 * Class for communication with abt_options column and retention of values.
 *
 * @author Ken-chan
 * @package WordPress
 * @subpackage Admin Bar Tools
 * @since 1.7.0
 */

declare( strict_types = 1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'You do not have access rights.' );
}

/**
 * Abt_Options class.
 *
 * @phpstan-type abt_options_items_key_types "psi"|"lh"|"gsc"|"gc"|"gi"|"bi"|"twitter"|"facebook"|"hatena"
 *
 * @phpstan-type abt_options_items_types array<abt_options_items_key_types, array{
 *      "name": string,
 *      "shortname": abt_options_items_key_types,
 *      "status": bool,
 *      "url": string,
 *      "adminurl": string,
 *      "order": int
 * }>
 *
 * @phpstan-type abt_options_array_type array{
 *   "items": abt_options_items_types,
 *   "locale": string,
 *   "sc": int,
 *   "theme_support": bool,
 *   "version": string
 * }
 *
 * @phpstan-type abt_options_types abt_options_array_type|false
 */
class Abt_Options extends Abt_Base {
	/**
	 * Property that holds all values of abt_options.
	 *
	 * @phpstan-var abt_options_types $abt_options
	 * @var array|false $abt_options
	 */
	private $abt_options;

	/**
	 * Property that holds the items of abt_options.
	 *
	 * @phpstan-var abt_options_items_types $items
	 * @var array $items
	 */
	private $items;

	/**
	 * Property that holds the locale of abt_options.
	 *
	 * @var string $locale
	 */
	private $locale;

	/**
	 * Property that holds the sc (Google Search Console) of abt_options.
	 *
	 * @var int $sc
	 */
	private $sc;

	/**
	 * Property that holds the theme_support of abt_options.
	 *
	 * @var bool $theme_support
	 */
	private $theme_support;

	/**
	 * Property that holds the version of abt_options.
	 *
	 * @var string $version
	 */
	private $version;

	/**
	 * Property that holds whether the abt_options column exists.
	 *
	 * @var bool $abt_options_exists
	 */
	private $abt_options_exists;

	/**
	 * Constructor.
	 * Get the abt_options column and store it in the property.
	 *
	 * @@phpstan-param abt_options_type|null $dependencies
	 * @param array<string|int|bool|array<string>>|null $dependencies An array of dependencies.
	 */
	public function __construct( ?array $dependencies = null ) {
		/**
		 * $abt_options.
		 *
		 * @phpstan-var abt_options_types|false|null $abt_options
		 */
		$abt_options = $dependencies ?? get_option( 'abt_options' );

		if ( $abt_options ) {
			$this->abt_options_exists = true;

			if ( ! $this->is_key_exists( $abt_options ) ) {
				$abt_options = $this->update_abt_options( $abt_options );
			}
		} else {
			$this->abt_options_exists = false;
			$this->register_options();
			$this->abt_options_exists = true;

			/**
			 * $abt_options.
			 *
			 * @phpstan-var abt_options_types|false $abt_options
			 */
			$abt_options = get_option( 'abt_options' );
		}

		if ( is_array( $abt_options ) ) {
			$this->abt_options = $abt_options;

			$this->set_properties();
		}
	}

	/**
	 * Method to check if the key specified in abt_options exists.
	 *
	 * @param array<mixed>|bool $abt_options An array of abt_options.
	 */
	public function is_key_exists( array|bool $abt_options ): bool {
		if ( is_bool( $abt_options ) ) {
			return false;
		}

		return match ( true ) {
			! array_key_exists( 'items', $abt_options ) => false,
			! array_key_exists( 'locale', $abt_options ) => false,
			! array_key_exists( 'sc', $abt_options ) => false,
			! array_key_exists( 'theme_support', $abt_options ) => false,
			! array_key_exists( 'version', $abt_options ) => false,
			default => true,
		};
	}

	/**
	 * Register wp_options column.
	 */
	public function register_options(): void {
		if ( ! $this->get_abt_options() ) {
			$this->set_items( $this->create_items() )
				->set_locale( get_locale() )
				->set_sc( 0 )
				->set_theme_support( true )
				->set_version( $this->get_version() )
				->save();
		}
	}

	/**
	 * Method to set the value of abt_options to the property.
	 */
	private function set_properties(): void {
		if ( $this->abt_options ) {
			$this->abt_options_exists = true;

			$this->items         = $this->abt_options['items'];
			$this->locale        = $this->abt_options['locale'];
			$this->sc            = $this->abt_options['sc'];
			$this->theme_support = $this->abt_options['theme_support'];
			$this->version       = $this->abt_options['version'];
		}
	}

	/**
	 * A method that returns whether or not the abt_options column exists.
	 */
	public function is_abt_options_exists(): bool {
		return $this->abt_options_exists;
	}

	/**
	 * A method that returns the value of theme_support.
	 */
	public function is_theme_support(): bool {
		return $this->theme_support;
	}

	/**
	 * A method that compares the value of version and returns a boolean value.
	 *
	 * @param string $version The version to compare.
	 */
	public function is_version( string $version ): bool {
		return version_compare( $this->version, $version, '=' );
	}

	/**
	 * Method to add missing items to abt_options.
	 *
	 * @phpstan-param abt_options_array_type $abt_options
	 * @param array $abt_options An array of abt_options.
	 *
	 * @phpstan-return abt_options_array_type
	 * @return array
	 */
	public function update_abt_options( array $abt_options ): array {
		foreach ( self::OPTIONS_KEY as $key_name ) {
			if ( ! array_key_exists( $key_name, $abt_options ) ) {
				if ( 'theme_support' === $key_name ) {
					$abt_options['theme_support'] = true;
				}
			}
			update_option( 'abt_options', $abt_options );
		}

		return $abt_options;
	}

	/**
	 * A method that returns all values of abt_options.
	 *
	 * @phpstan-return abt_options_types
	 * @return array|bool
	 */
	public function get_all_options(): array|bool {
		return $this->abt_options;
	}

	/**
	 * A method that returns the items.
	 *
	 * @phpstan-return abt_options_items_types
	 * @return array
	 */
	public function get_items(): array {
		return $this->items;
	}

	/**
	 * A method that returns the locale.
	 */
	public function get_locale(): string {
		return $this->locale;
	}

	/**
	 * A method that returns the sc (SearchConsole) value.
	 */
	public function get_sc(): int {
		return $this->sc;
	}

	/**
	 * A method that returns the theme_support value.
	 */
	public function get_theme_support(): bool {
		return $this->theme_support;
	}

	/**
	 * A method to change the value of a items.
	 *
	 * @phpstan-param abt_options_items_types $items
	 * @param array $items Items Value.
	 */
	public function set_items( array $items ): Abt_Options {
		$this->items = $items;

		return $this;
	}

	/**
	 * A method to change the value of a locale.
	 *
	 * @param string $locale Locale Value.
	 */
	public function set_locale( string $locale ): Abt_Options {
		$this->locale = $locale;

		return $this;
	}

	/**
	 * A method to change the value of a sc (SearchConsole).
	 *
	 * @param int $sc SearchConsole Value.
	 */
	public function set_sc( int $sc ): Abt_Options {
		$this->sc = $sc;

		return $this;
	}

	/**
	 * A method to change the value of a theme_support.
	 *
	 * @param bool $theme_support Theme Support Value.
	 */
	public function set_theme_support( bool $theme_support ): Abt_Options {
		$this->theme_support = $theme_support;

		return $this;
	}

	/**
	 * A method to change the value of a version.
	 *
	 * @param string $version Version Value.
	 */
	public function set_version( string $version ): Abt_Options {
		$this->version = $version;

		return $this;
	}

	/**
	 * Method to save the value in the abt_options column.
	 */
	public function save(): bool {
		$this->abt_options = [
			'items'         => $this->items,
			'locale'        => $this->locale,
			'sc'            => $this->sc,
			'theme_support' => $this->theme_support,
			'version'       => $this->version,
		];

		return update_option( 'abt_options', $this->abt_options );
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
				'status'    => $this->is_abt_options_exists() ? $this->get_items()[ $key ]['status'] : true,
				'url'       => $value['url'],
				'adminurl'  => $value['admin'],
				'order'     => $value['order'],
			];
		}

		return $items;
	}
}
