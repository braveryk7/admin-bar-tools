<?php
/**
 * Returns data class
 *
 * @author Ken-chan
 * @package WordPress
 * @subpackage Admin Bar Tools
 * @since 0.0.1
 */

declare( strict_types = 1 );

/**
 * Returns data for view and database.
 */
class Abt_Return_Data {
	const TABLE_NAME  = 'abt';
	const DB_VERSION  = '1.0';
	const PSI_LOCALES = [
		'en_US' => 'us',
		'ja'    => 'ja',
	];

	/**
	 * Options table locale.
	 *
	 * @var string
	 */
	private static $locale;

	/**
	 * _abt table locale.
	 *
	 * @var string
	 */
	private static $abt_locale;

	/**
	 * Pagespeed Insight URL by country.
	 *
	 * @var string
	 */
	private $psi_url;

	/**
	 * Pagespeed Insight admin page URL by country.
	 *
	 * @var string
	 */
	private $psi_admin_url;

	/**
	 * Various service URL.
	 *
	 * @var array
	 */
	public static $location_url = [];

	/**
	 * Array for database insertion.
	 *
	 * @var array
	 */
	public static $insert_data = [];

	/**
	 * Perform data initialization for view and database insertion.
	 */
	private function __construct() {
		self::$locale     = get_locale();
		self::$abt_locale = get_option( 'abt_locale' );

		if ( true === array_key_exists( self::$locale, self::PSI_LOCALES ) ) {
			$this->psi_admin_url = 'https://developers.google.com/speed/pagespeed/insights/?hl=' . self::PSI_LOCALES[ self::$locale ];
			$this->psi_url       = $this->psi_admin_url . '&url=';
		} else {
			$this->psi_admin_url = 'https://developers.google.com/speed/pagespeed/insights/?hl=us';
			$this->psi_url       = $this->psi_admin_url . '&url=';
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
	public static function change_locale( string $new_locale ): array {
		new self();

		if ( true === array_key_exists( $new_locale, self::PSI_LOCALES ) ) {
			$insert_admin_url = 'https://developers.google.com/speed/pagespeed/insights/?hl=' . self::PSI_LOCALES[ $new_locale ];
			$insert_url       = $insert_admin_url . '&url=';

			self::$insert_data['1']['url']      = $insert_url;
			self::$insert_data['1']['adminurl'] = $insert_admin_url;
		} else {
			$insert_admin_url = 'https://developers.google.com/speed/pagespeed/insights/?hl=us';
			$insert_url       = $insert_admin_url . '&url=';

			self::$insert_data['1']['url']      = $insert_url;
			self::$insert_data['1']['adminurl'] = $insert_admin_url;
		}
		return self::$insert_data;
	}
}
