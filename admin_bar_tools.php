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
    License: GPL2
    */

    load_plugin_textdomain('admin-bar-tools', false, basename( dirname( __FILE__ ) ) . '/languages');

    include_once(dirname(__FILE__).'/modules/abt_admin.php');
    include_once(dirname(__FILE__).'/modules/abt_db.php');

    register_activation_hook(__FILE__, 'abt_create_db');
    register_activation_hook(__FILE__, 'abt_default_insert_db');

    add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'AdminSettings::add_settings_links');

    register_uninstall_hook(__FILE__, 'abt_delete_db');

    class Constant {
        const TEXTDOMAIN = 'admin-bar-tools';
    }

    function abt_add_adminbar($wpAdminbar) {

        $url = urlencode(get_pagenum_link(get_query_var('paged')));
        $joinUrlLists = ['1001', '1002', '2002', '2003', '3001', '3002'];
    
        $wpAdminbar->add_node([
            'id' => 'abt',
            'title' => __('Admin Bar Tools', 'admin-bar-tools'),
            'meta' => [
                'target' => 'abt'
            ]
        ]);
    
        global $wpdb;
        $tableName = $wpdb->prefix . 'abt';
    
        $result = $wpdb->get_results("SELECT * FROM $tableName");
    
        foreach($result as $key => $value) {
            if($value->status === '1') {
                if(!is_admin() && $value->id === '3003') {
                    $linkUrl = $value->url . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                } elseif(!is_admin()) {
                    $linkUrl = in_array($value->id, $joinUrlLists, true) ? $value->url . $url : $value->url;
                } elseif(is_admin()) {
                    $linkUrl = $value->adminurl;
                };
                $wpAdminbar->add_node([
                    'id' => $value->shortname,
                    'title' => __($value->name, 'admin-bar-tools'),
                    'parent' => 'abt',
                    'href' => $linkUrl,
                    'meta' => [
                        'target' => '_blank'
                    ]
                ]);
            };
        };
    }
    
    add_action('admin_bar_menu', 'abt_add_adminbar', 999);