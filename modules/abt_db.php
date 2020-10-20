<?php

    function abt_db() {
        global $wpdb;
        $tableName = $wpdb->prefix . 'abt';
        if($wpdb->get_var("SHOW TABLES LIKE '".$tableName."'") != $tableName) {
            abt_create_db();
        }
    }

    function abt_create_db() {
        global $wpdb;
        $dbVersion = '1.0';

        $tableName = $wpdb->prefix . 'abt';
        $charsetCollate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $tableName (
            id smallint(4) UNSIGNED NOT NULL PRIMARY KEY,
            shortname varchar(255) NOT NULL,
            name varchar(255) NOT NULL,
            status tinyint(1) UNSIGNED NOT NULL,
            url text NOT NULL,
            adminurl text NOT NULL
        ) $charsetCollate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        add_option('db_version', $dbVersion);
    }

    function abt_default_insert_db() {
        global $wpdb;
        $tableName = $wpdb->prefix . 'abt';

        $TEXTDOMAIN = 'admin-bar-tools';

        $defaultValue = [
            1 => [
                'id' => 1001,
                'shortname' => 'psi',
                'name' => __('PageSpeed Insights', $TEXTDOMAIN),
                'status' => 1,
                'url' => 'https://developers.google.com/speed/pagespeed/insights/?hl=JA&url=',
                'adminurl' => 'https://developers.google.com/speed/pagespeed/insights/?hl=JA',
            ],
            2 => [
                'id' => 1002,
                'shortname' => 'lh',
                'name' => __('Lighthouse', $TEXTDOMAIN),
                'status' => 1,
                'url' => 'https://googlechrome.github.io/lighthouse/viewer/?psiurl=',
                'adminurl' => 'https://googlechrome.github.io/lighthouse/viewer/',
            ],
            3 => [
                'id' => 2001,
                'shortname' => 'gsc',
                'name' => __('Google Search Console', $TEXTDOMAIN),
                'status' => 1,
                'url' => 'https://search.google.com/search-console',
                'adminurl' => 'https://search.google.com/search-console',
            ],
            4 => [
                'id' => 2002,
                'shortname' => 'gc',
                'name' => __('Google Cache', $TEXTDOMAIN),
                'status' => 1,
                'url' => 'https://webcache.googleusercontent.com/search?q=cache%3A',
                'adminurl' => 'https://webcache.googleusercontent.com/search?q=cache%3A',
            ],
            5 => [
                'id' => 2003,
                'shortname' => 'gi',
                'name' => __('Google Index', $TEXTDOMAIN),
                'status' => 1,
                'url' => 'https://www.google.com/search?q=site%3A',
                'adminurl' => 'https://www.google.com/search?q=site%3A',
            ],
            6 => [
                'id' => 3001,
                'shortname' => 'twitter',
                'name' => __('Twitter Search', $TEXTDOMAIN),
                'status' => 1,
                'url' => 'https://twitter.com/search?f=live&q=',
                'adminurl' => 'https://twitter.com/',
            ],
            7 => [
                'id' => 3002,
                'shortname' => 'facebook',
                'name' => __('Facebook Search', $TEXTDOMAIN),
                'status' => 1,
                'url' => 'https://www.facebook.com/search/top?q=',
                'adminurl' => 'https://www.facebook.com/',
            ],
            8 => [
                'id' => 3003,
                'shortname' => 'hatena',
                'name' => __('Hatena Bookmark', $TEXTDOMAIN),
                'status' => 1,
                'url' => 'https://b.hatena.ne.jp/entry/s/',
                'adminurl' => 'https://b.hatena.ne.jp/',
            ],
        ];

        foreach($defaultValue as $key => $value) {
            $wpdb->insert(
                $tableName,
                [
                    'id' => $defaultValue[$key]['id'],
                    'shortname' => $defaultValue[$key]['shortname'],
                    'name' => $defaultValue[$key]['name'],
                    'status' => $defaultValue[$key]['status'],
                    'url' => $defaultValue[$key]['url'],
                    'adminurl' => $defaultValue[$key]['adminurl']
                ],
                [
                    '%d',
                    '%s',
                    '%s',
                    '%d',
                    '%s',
                    '%s'
                ]
            );
        };
    }

    register_activation_hook(__FILE__, 'abt_create_db');
    register_activation_hook(__FILE__, 'abt_default_insert_db');
