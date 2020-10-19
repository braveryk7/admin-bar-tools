<?php
    function abt_add_adminbar($wpAdminbar) {

    $url = urlencode(get_pagenum_link(get_query_var('paged')));
    $joinUrlLists = ['1', '2', '4', '5'];

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
            $wpAdminbar->add_node([
                'id' => $value->shortname,
                'title' => $value->name,
                'parent' => 'abt',
                'href' => in_array($value->id, $joinUrlLists, true) ? $value->url . $url : $value->url,
                'meta' => [
                    'target' => '_blank'
                ]
            ]);
        };
    };
    }

    add_action('admin_bar_menu', 'abt_add_adminbar', 999);