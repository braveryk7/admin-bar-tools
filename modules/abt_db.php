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

        add_option('abt_db_version', $dbVersion);
    }

    function abt_default_insert_db() {
        global $wpdb;
        $tableName = $wpdb->prefix . 'abt';

        $locale = get_locale();

        $urls = new Constant();

        $defaultValue = [
            1 => [
                'id' => 1001,
                'shortname' => 'psi',
                'name' => __('PageSpeed Insights', Constant::TEXTDOMAIN),
                'status' => 1,
                'url' => Constant::$locationUrl['psi'],
                'adminurl' => Constant::$locationUrl['psiAdmin'],
            ],
            2 => [
                'id' => 1002,
                'shortname' => 'lh',
                'name' => __('Lighthouse', Constant::TEXTDOMAIN),
                'status' => 1,
                'url' => Constant::$locationUrl['lh'],
                'adminurl' => Constant::$locationUrl['lhAdmin'],
            ],
            3 => [
                'id' => 2001,
                'shortname' => 'gsc',
                'name' => __('Google Search Console', Constant::TEXTDOMAIN),
                'status' => 1,
                'url' => Constant::$locationUrl['gsc'],
                'adminurl' => Constant::$locationUrl['gscAdmin'],
            ],
            4 => [
                'id' => 2002,
                'shortname' => 'gc',
                'name' => __('Google Cache', Constant::TEXTDOMAIN),
                'status' => 1,
                'url' => Constant::$locationUrl['gc'],
                'adminurl' => Constant::$locationUrl['gcAdmin'],
            ],
            5 => [
                'id' => 2003,
                'shortname' => 'gi',
                'name' => __('Google Index', Constant::TEXTDOMAIN),
                'status' => 1,
                'url' => Constant::$locationUrl['gi'],
                'adminurl' => Constant::$locationUrl['giAdmin'],
            ],
            6 => [
                'id' => 3001,
                'shortname' => 'twitter',
                'name' => __('Twitter Search', Constant::TEXTDOMAIN),
                'status' => 1,
                'url' => Constant::$locationUrl['twitter'],
                'adminurl' => Constant::$locationUrl['twitterAdmin'],
            ],
            7 => [
                'id' => 3002,
                'shortname' => 'facebook',
                'name' => __('Facebook Search', Constant::TEXTDOMAIN),
                'status' => 1,
                'url' => Constant::$locationUrl['facebook'],
                'adminurl' => Constant::$locationUrl['facebookAdmin'],
            ],
            8 => [
                'id' => 3003,
                'shortname' => 'hatena',
                'name' => __('Hatena Bookmark', Constant::TEXTDOMAIN),
                'status' => 1,
                'url' => Constant::$locationUrl['hatena'],
                'adminurl' => Constant::$locationUrl['hatenaAdmin'],
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

        add_option('abt_locale', Constant::$locale);
    }

    function abt_delete_db() {
        global $wpdb;
        $tableName = $wpdb->prefix . 'abt';
    
        delete_option('abt_locale');

        $sql = "DROP TABLE $tableName;";
        $wpdb->query($sql);
    }