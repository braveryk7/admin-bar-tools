<?php
/**
 * Plugin Name: Admin Bar Tools
 * Plugin URI:  https://www.braveryk7.com/
 * Description: A plugin that allows you to add useful links to the admin bar.
 * Version:     1.5.3
 * Author:      Ken-chan
 * Author URI:  https://twitter.com/braveryk7
 * Text Domain: admin-bar-tools
 * Domain Path: /languages
 * License:     GPL2
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

load_plugin_textdomain( 'admin-bar-tools', false, basename( dirname( __FILE__ ) ) . '/languages' );

require_once dirname( __FILE__ ) . '/class/class-abt-base.php';
require_once dirname( __FILE__ ) . '/class/class-abt-phpver-judge.php';

$get_php_version_bool = new Abt_Phpver_Judge();
if ( ! $get_php_version_bool->judgment( Abt_Base::get_required_php_version() ) ) {
	$get_php_version_bool->deactivate(
		__FILE__,
		Abt_Base::get_plugin_name(),
		Abt_Base::get_required_php_version()
	);
} elseif ( $get_php_version_bool->judgment( Abt_Base::get_required_php_version() ) ) {
	require_once dirname( __FILE__ ) . '/class/class-abt-activate.php';
	require_once dirname( __FILE__ ) . '/class/class-abt-admin-page.php';
	require_once dirname( __FILE__ ) . '/class/class-abt-add-admin-bar.php';

	/**
	 * Start admin page.
	 */
	new Abt_Admin_Page();

	/**
	 * Plugin activate.
	 */
	new Abt_Activate();

	/**
	 * Add admin bar menu.
	 */
	new Abt_Add_Admin_Bar();

	/**
	 * Plugin uninstall hook.
	 * Delete wp_options column.
	 */
	register_uninstall_hook( __FILE__, 'Abt_Activate::uninstall_options' );
}
