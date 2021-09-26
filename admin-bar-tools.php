<?php
/**
 * Plugin Name: Admin Bar Tools
 * Plugin URI:  https://www.braveryk7.com/
 * Description: A plugin that allows you to add useful links to the admin bar.
 * Version:     1.3.0
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

require_once dirname( __FILE__ ) . '/class/class-judgment-php-version.php';

$require_php_version  = '7.3.0';
$get_php_version_bool = new Judgment_Php_Version();
if ( false === $get_php_version_bool->judgment( $require_php_version ) ) {
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
} elseif ( true === $get_php_version_bool->judgment( $require_php_version ) ) {
	require_once dirname( __FILE__ ) . '/class/class-abt-return-data.php';
	require_once dirname( __FILE__ ) . '/class/class-abt-admin-settings-page.php';
	require_once dirname( __FILE__ ) . '/class/class-abt-admin-page.php';
	require_once dirname( __FILE__ ) . '/class/class-abt-connect-database.php';
	require_once dirname( __FILE__ ) . '/class/class-abt-add-admin-bar.php';

	$admin_page = new Abt_Admin_Page();

	/**
	 * Check database version.
	 */
	function abt_database_check() {
		if ( current_user_can( 'manage_options' ) ) {
			$db_class = new Abt_Connect_Database();
			if ( ! $db_class->abt_db_check() ) {
				$db_class->abt_default_insert_db();
				$db_class->add_abt_option();
			}
		}
	}
	add_action( 'admin_init', 'abt_database_check' );

	/**
	 * Activation Hook.
	 */
	function abt_activate() {
		$db_class = new Abt_Connect_Database();
		register_activation_hook( __FILE__, [ $db_class, 'abt_search_table' ] );
		register_activation_hook( __FILE__, [ $db_class, 'abt_default_insert_db' ] );
	};
	abt_activate();

	/**
	 * Uninstall Hook.
	 */
	function abt_uninstall() {
		register_uninstall_hook( __FILE__, 'Abt_Connect_Database::abt_delete_db' );
	}
	abt_uninstall();

	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'Abt_Admin_Settings_Page::add_settings_links' );

	add_action( 'admin_bar_menu', 'Abt_Add_Admin_Bar::add_admin_bar', 999 );
}
