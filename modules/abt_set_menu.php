<?php
    function abt_add_adminbar($wpAdminbar) {

    $url = urlencode(get_pagenum_link(get_query_var('paged')));
    $joinUrlLists = ['1001', '1002', '2002', '2003', '3001', '3002'];

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
                'title' => $value->name,
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