<?php
/*
Plugin Name: Admin Bar Tools
Plugin URI: https://www.braveryk7.com/
Description: Use the admin bar conveniently.
Version: 0.1
Author: Ken-chan
Author URI: https://twitter.com/braveryk7
*/

include_once(dirname(__FILE__).'/modules/abt_admin.php');
include_once(dirname(__FILE__).'/modules/abt_db.php');

register_activation_hook(__FILE__, 'abt_create_db');
register_activation_hook(__FILE__, 'abt_default_insert_db');

function abt_add_adminbar($wpAdminbar) {

    $url = urlencode(get_pagenum_link(get_query_var('paged')));

    $wpAdminbar->add_node([
        'id' => 'abt',
        'title' => 'Admin Bar Tools',
        'meta' => [
            'target' => 'abt'
        ]
    ]);

    global $wpdb;
    $tableName = $wpdb->prefix . 'abt';

    $result = $wpdb->get_results("SELECT * FROM $tableName");

    // foreach($result as $key => $value) {

    // }

    $wpAdminbar->add_node([
        'id' => 'abtpsi',
        'title' => 'PageSpeed Insights',
        'parent' => 'abt',
        'href' => $result[0]->url . $url,
        'meta' => [
            'target' => '_blank'
        ]
    ]);

    $wpAdminbar->add_node([
        'id' => 'abtlh',
        'title' => 'Lighthouse',
        'parent' => 'abt',
        'href' => $result[1]->url . $url,
        'meta' => [
            'target' => '_blank'
        ]
    ]);

    $wpAdminbar->add_node([
        'id' => 'abtgsc',
        'title' => 'Google Search Console',
        'parent' => 'abt',
        'href' => $result[2]->url,
        'meta' => [
            'target' => '_blank'
        ]
    ]);

    $wpAdminbar->add_node([
        'id' => 'abtgc',
        'title' => 'Google Cache',
        'parent' => 'abt',
        'href' => $result[3]->url . $url,
        'meta' => [
            'target' => '_blank'
        ]
    ]);

    $wpAdminbar->add_node([
        'id' => 'abtgidx',
        'title' => 'Google Index',
        'parent' => 'abt',
        'href' => $result[4]->url . $url,
        'meta' => [
            'target' => '_blank'
        ]
    ]);
}

add_action('admin_bar_menu', 'abt_add_adminbar', 999);