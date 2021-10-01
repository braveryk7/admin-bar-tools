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

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'You do not have access rights.' );
}

/**
 * Returns data for view and database.
 */
class Abt_Return_Data {
	const TABLE_NAME  = 'abt';
	const DB_VERSION  = '1.3';
	const PSI_LOCALES = [
		'ar'    => [
			'id'   => 'ar',
			'name' => 'العربية', // Arabic.
		],
		'bg_BG' => [
			'id'   => 'bg',
			'name' => 'Български', // Bulgarian.
		],
		'ca'    => [
			'id'   => 'ca',
			'name' => 'Català', // Catalan.
		],
		'cs'    => [
			'id'   => 'cs',
			'name' => 'Čeština', // Czech.
		],
		'da_DK' => [
			'id'   => 'da',
			'name' => 'Dansk', // Danish.
		],
		'da_DE' => [
			'id'   => 'de',
			'name' => 'Deutsch', // German.
		],
		'el'    => [
			'id'   => 'el',
			'name' => 'Ελληνικά', // Greek.
		],
		'en_US' => [
			'id'   => 'us',
			'name' => 'English (United States)', // English(US).
		],
		'en_GB' => [
			'id'   => 'en-GB',
			'name' => 'English (UK)', // English(UK).
		],
		'es_ES' => [
			'id'   => 'es',
			'name' => 'Español', // Spanish.
		],
		'fi'    => [
			'id'   => 'fi',
			'name' => 'Suomi', // Finnish.
		],
		'tl'    => [
			'id'   => 'fil',
			'name' => 'Tagalog', // Tagalog.
		],
		'fr_FR' => [
			'id'   => 'fr',
			'name' => 'Français', // French.
		],
		'hi_IN' => [
			'id'   => 'hi',
			'name' => 'हिन्दी', // Hindi.
		],
		'hr'    => [
			'id'   => 'hr',
			'name' => 'Hrvatski', // Croatian.
		],
		'hu_HU' => [
			'id'   => 'hu',
			'name' => 'Magyar', // Hungarian.
		],
		'id_ID' => [
			'id'   => 'id',
			'name' => 'Bahasa Indonesia', // Indonesian.
		],
		'it_IT' => [
			'id'   => 'it',
			'name' => 'Italiano', // Italian.
		],
		'he_IL' => [
			'id'   => 'iw',
			'name' => 'עִבְרִית', // Hebrew.
		],
		'ja'    => [
			'id'   => 'ja',
			'name' => '日本語', // Japanese.
		],
		'ko_KR' => [
			'id'   => 'ko',
			'name' => '한국어', // Korean.
		],
		'lt_LT' => [
			'id'   => 'lt',
			'name' => 'Lietuvių kalba', // Lithuanian.
		],
		'lv'    => [
			'id'   => 'lv',
			'name' => 'Latviešu valoda', // Latvian.
		],
		'nl_NL' => [
			'id'   => 'nl',
			'name' => 'Nederlands', // Dutch.
		],
		'nb_NO' => [
			'id'   => 'no',
			'name' => 'Norsk bokmål', // Norwegian.
		],
		'pl_PL' => [
			'id'   => 'pl',
			'name' => 'Polski', // Polish.
		],
		'pt_BR' => [
			'id'   => 'pt-BR',
			'name' => 'Português do Brasil', // Portuguese(Brazil).
		],
		'pt_PT' => [
			'id'   => 'pt-PT',
			'name' => 'Português', // Portuguese.
		],
		'ro_RO' => [
			'id'   => 'ro',
			'name' => 'Română', // Romanian.
		],
		'ru_RU' => [
			'id'   => 'ru',
			'name' => 'Русский', // Russian.
		],
		'sk_SK' => [
			'id'   => 'sk',
			'name' => 'Slovenčina', // Slovak.
		],
		'sl_SI' => [
			'id'   => 'sl',
			'name' => 'Slovenščina', // Slovenian.
		],
		'sr_RS' => [
			'id'   => 'sr',
			'name' => 'Српски језик', // Serbian.
		],
		'sv_SE' => [
			'id'   => 'sv',
			'name' => 'Svenska', // Swedish.
		],
		'th'    => [
			'id'   => 'th',
			'name' => 'ไทย', // Thai.
		],
		'tr_TR' => [
			'id'   => 'tr',
			'name' => 'Türkçe', // Turkish.
		],
		'uk'    => [
			'id'   => 'uk',
			'name' => 'Українська', // Ukrainian.
		],
		'vi'    => [
			'id'   => 'vi',
			'name' => 'Tiếng Việt', // Vietnamese.
		],
		'zh_CN' => [
			'id'   => 'zh-CN',
			'name' => '简体中文', // Simplified Chinese.
		],
		'zh_TW' => [
			'id'   => 'zh-TW',
			'name' => '繁體中文', // traditional Chinese.
		],
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
	 * Array for wp_option insertion.
	 *
	 * @var array
	 */
	public static $abt_status = [];

	/**
	 * Perform data initialization for view and database insertion.
	 */
	private function __construct() {
		self::$locale     = get_locale();
		self::$abt_locale = get_option( 'abt_locale' );

		if ( true === array_key_exists( self::$locale, self::PSI_LOCALES ) ) {
			$this->psi_admin_url = 'https://developers.google.com/speed/pagespeed/insights/?hl=' . self::PSI_LOCALES[ self::$locale ]['id'];
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
			'bi'            => 'https://www.bing.com/search?q=site%3a',
			'biAdmin'       => 'https://www.bing.com/search?q=site%3a',
			'twitter'       => 'https://twitter.com/search?f=live&q=',
			'twitterAdmin'  => 'https://twitter.com/',
			'facebook'      => 'https://www.facebook.com/search/top?q=',
			'facebookAdmin' => 'https://www.facebook.com/',
			'hatena'        => 'https://b.hatena.ne.jp/entry/s/',
			'hatenaAdmin'   => 'https://b.hatena.ne.jp/',
		];

		self::$abt_status += [
			'psi'      => [
				'name'      => __( 'PageSpeed Insights', 'admin-bar-tools' ),
				'shortname' => 'psi',
				'status'    => true,
				'url'       => self::$location_url['psi'],
				'adminurl'  => self::$location_url['psiAdmin'],
			],
			'lh'       => [
				'name'      => __( 'Lighthouse', 'admin-bar-tools' ),
				'shortname' => 'lh',
				'status'    => true,
				'url'       => self::$location_url['lh'],
				'adminurl'  => self::$location_url['lhAdmin'],
			],
			'gsc'      => [
				'name'      => __( 'Google Search Console', 'admin-bar-tools' ),
				'shortname' => 'gsc',
				'status'    => true,
				'url'       => self::$location_url['gsc'],
				'adminurl'  => self::$location_url['gscAdmin'],
			],
			'gc'       => [
				'name'      => __( 'Google Cache', 'admin-bar-tools' ),
				'shortname' => 'gc',
				'status'    => true,
				'url'       => self::$location_url['gc'],
				'adminurl'  => self::$location_url['gcAdmin'],
			],
			'gi'       => [
				'name'      => __( 'Google Index', 'admin-bar-tools' ),
				'shortname' => 'gi',
				'status'    => true,
				'url'       => self::$location_url['gi'],
				'adminurl'  => self::$location_url['giAdmin'],
			],
			'twitter'  => [
				'name'      => __( 'Twitter Search', 'admin-bar-tools' ),
				'shortname' => 'twitter',
				'status'    => true,
				'url'       => self::$location_url['twitter'],
				'adminurl'  => self::$location_url['twitterAdmin'],
			],
			'facebook' => [
				'name'      => __( 'Facebook Search', 'admin-bar-tools' ),
				'shortname' => 'facebook',
				'status'    => true,
				'url'       => self::$location_url['facebook'],
				'adminurl'  => self::$location_url['facebookAdmin'],
			],
			'hatena'   => [
				'name'      => __( 'Hatena Bookmark', 'admin-bar-tools' ),
				'shortname' => 'hatena',
				'status'    => true,
				'url'       => self::$location_url['hatena'],
				'adminurl'  => self::$location_url['hatenaAdmin'],
			],
			'bi'       => [
				'name'      => __( 'Bing Index', 'admin-bar-tools' ),
				'shortname' => 'bi',
				'status'    => true,
				'url'       => self::$location_url['bi'],
				'adminurl'  => self::$location_url['biAdmin'],
			],
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
			5 => [
				'id'        => 2011,
				'shortname' => 'bi',
				'name'      => __( 'Bing Index', 'admin-bar-tools' ),
				'status'    => 1,
				'url'       => self::$location_url['bi'],
				'adminurl'  => self::$location_url['biAdmin'],
			],
		];
	}

	/**
	 * Return options.
	 */
	public static function options() {
		new self();
		return self::$abt_status;
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
			$insert_admin_url = 'https://developers.google.com/speed/pagespeed/insights/?hl=' . self::PSI_LOCALES[ $new_locale ]['id'];
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
