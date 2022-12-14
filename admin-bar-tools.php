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
if ( false === $get_php_version_bool->judgment( Abt_Base::REQUIRED_PHP_VERSION ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
	if ( is_plugin_active( plugin_basename( __FILE__ ) ) ) {
		if ( is_admin() ) {
			require_once dirname( __FILE__ ) . '/modules/cancel-activate.php';
			cancel_activate();
		}
		deactivate_plugins( plugin_basename( __FILE__ ) );
	} else {
		echo '<p>' . esc_html_e( 'Admin Bar Tools requires at least PHP 7.3.0 or later.', 'admin-bar-tools' ) . esc_html_e( 'Please upgrade PHP.', 'admin-bar-tools' ) . '</p>';
		exit;
	}
} elseif ( true === $get_php_version_bool->judgment( Abt_Base::REQUIRED_PHP_VERSION ) ) {
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
