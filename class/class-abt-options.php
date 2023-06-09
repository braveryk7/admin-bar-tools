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
 */
class Abt_Options extends Abt_Base {
	/**
	 * Static instance property that holds itself.
	 *
	 * @var Abt_Options $instance
	 */
	private static $instance;

	/**
	 * Property that holds the contents of the abt_options column.
	 *
	 * @var array<mixed>|bool $abt_options
	 */
	private $abt_options;

	/**
	 * Instantiate and return itself.
	 */
	public function get_instance(): Abt_Options {
		return new self();
	}
}
