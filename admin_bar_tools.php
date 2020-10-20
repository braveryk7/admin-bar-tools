<?php
    /*
    Plugin Name: Admin Bar Tools
    Plugin URI: https://www.braveryk7.com/
    Description: Use the admin bar conveniently.
    Version: 0.1
    Author: Ken-chan
    Author URI: https://twitter.com/braveryk7
    Text Domain: admin-bar-tools
    Domain Path: /languages
    */

    load_plugin_textdomain('admin-bar-tools', false, basename( dirname( __FILE__ ) ) . '/languages');

    include_once(dirname(__FILE__).'/modules/abt_admin.php');
    include_once(dirname(__FILE__).'/modules/abt_db.php');
    include_once(dirname(__FILE__).'/modules/abt_set_menu.php');

    register_activation_hook(__FILE__, 'abt_create_db');
    register_activation_hook(__FILE__, 'abt_default_insert_db');
