<?php

    function abl_db() {
        global $wpdb;
        $tableName = $wpdb->prefix . 'abl';
        if($wpdb->get_var("SHOW TABLES LIKE '".$tableName."'") != $tableName) {
            abl_create_db();
        }
    }

    function abl_create_db() {
        global $wpdb;
        $dbVersion = '1.0';

        $tableName = $wpdb->prefix . 'abl';
        $charsetCollate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $tableName (
            id smallint(4) UNSIGNED NOT NULL PRIMARY KEY,
            name varchar(255) NOT NULL,
            status tinyint(1) UNSIGNED NOT NULL,
            url text NOT NULL
        ) $charsetCollate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        add_option('db_version', $dbVersion);
    }

    function abl_default_insert_db() {
        global $wpdb;
        $tableName = $wpdb->prefix . 'abl';

        $defaultValue = [
            1 => [
                'id' => 1,
                'name' => 'PageSpeed Insights',
                'status' => 1,
                'url' => 'https://developers.google.com/speed/pagespeed/insights/?hl=JA&url='
            ],
            2 => [
                'id' => 2,
                'name' => 'Lighthouse',
                'status' => 1,
                'url' => 'https://googlechrome.github.io/lighthouse/viewer/?psiurl='
            ],
            3 => [
                'id' => 3,
                'name' => 'Google Search Console',
                'status' => 1,
                'url' => 'https://search.google.com/search-console'
            ],
            4 => [
                'id' => 4,
                'name' => 'Google Cache',
                'status' => 1,
                'url' => 'http://webcache.googleusercontent.com/search?q=cache%3A'
            ],
            5 => [
                'id' => 5,
                'name' => 'Google Index',
                'status' => 1,
                'url' => 'https://www.google.com/search?q=site%3A'
            ]
        ];

        foreach($defaultValue as $key => $value) {
            $wpdb->insert(
                $tableName,
                [
                    'id' => $defaultValue[$key]['id'],
                    'name' => $defaultValue[$key]['name'],
                    'status' => $defaultValue[$key]['status'],
                    'url' => $defaultValue[$key]['url']
                ],
                [
                    '%d',
                    '%s',
                    '%d',
                    '%s'
                ]
            );
        };
    }
