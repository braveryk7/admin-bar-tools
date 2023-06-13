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
 * @phpstan-type abt_options_items_types array{
 *    string: array{
 *      "name": string,
 *      "shortname": string,
 *      "status": bool,
 *      "url": string,
 *      "adminurl": string,
 *      "order": int
 *    }
 * }
 *
 * @phpstan-type abt_options_types array{
 *   "items": abt_options_items_types,
 *   "locale": string,
 *   "sc": int,
 *   "theme_support": bool,
 *   "version": string
 * }|bool
 */
class Abt_Options extends Abt_Base {
	/**
	 * Static instance property that holds itself.
	 *
	 * @var Abt_Options $instance
	 */
	private static $instance;

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
	 */
	private function __construct() {
		/**
		 * $abt_options.
		 *
		 * @phpstan-var abt_options_types $abt_options
		 */
		$abt_options = get_option( 'abt_options' );

		if ( $abt_options && is_array( $abt_options ) ) {
			$this->abt_options_exists = true;

			$this->items         = $abt_options['items'];
			$this->locale        = $abt_options['locale'];
			$this->sc            = $abt_options['sc'];
			$this->theme_support = $abt_options['theme_support'];
			$this->version       = $abt_options['version'];
		} else {
			$this->abt_options_exists = false;
		}
	}

	/**
	 * Instantiate and return itself.
	 */
	public static function get_instance(): Abt_Options {
		return new self();
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
}
