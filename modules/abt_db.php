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

        $TEXTDOMAIN = 'admin-bar-tools';

        $locale = get_locale();

        $locationUrl = [
            'psi' => 'https://developers.google.com/speed/pagespeed/insights/?hl=US&url=',
            'psiAdmin' => 'https://developers.google.com/speed/pagespeed/insights/?hl=US',
            'lh' => 'https://googlechrome.github.io/lighthouse/viewer/?psiurl=',
            'lhAdmin' => 'https://googlechrome.github.io/lighthouse/viewer/',
            'gsc' => 'https://search.google.com/search-console',
            'gscAdmin' => 'https://search.google.com/search-console',
            'gc' => 'https://webcache.googleusercontent.com/search?q=cache%3A',
            'gcAdmin' => 'https://webcache.googleusercontent.com/search?q=cache%3A',
            'gi' => 'https://www.google.com/search?q=site%3A',
            'giAdmin' => 'https://www.google.com/search?q=site%3A',
            'twitter' => 'https://twitter.com/search?f=live&q=',
            'twitterAdmin' => 'https://twitter.com/',
            'facebook' => 'https://www.facebook.com/search/top?q=',
            'facebookAdmin' => 'https://www.facebook.com/',
            'hatena' => 'https://b.hatena.ne.jp/entry/s/',
            'hatenaAdmin' => 'https://b.hatena.ne.jp/',
        ];

        if($locale === 'ja') {
            $locationUrl += [
                'psi' => 'https://developers.google.com/speed/pagespeed/insights/?hl=JA&url=',
                'psiAdmin' => 'https://developers.google.com/speed/pagespeed/insights/?hl=JA'
            ];
        }

        $defaultValue = [
            1 => [
                'id' => 1001,
                'shortname' => 'psi',
                'name' => __('PageSpeed Insights', $TEXTDOMAIN),
                'status' => 1,
                'url' => $locationUrl['psi'],
                'adminurl' => $locationUrl['psiAdmin'],
            ],
            2 => [
                'id' => 1002,
                'shortname' => 'lh',
                'name' => __('Lighthouse', $TEXTDOMAIN),
                'status' => 1,
                'url' => $locationUrl['lh'],
                'adminurl' => $locationUrl['lhAdmin'],
            ],
            3 => [
                'id' => 2001,
                'shortname' => 'gsc',
                'name' => __('Google Search Console', $TEXTDOMAIN),
                'status' => 1,
                'url' => $locationUrl['gsc'],
                'adminurl' => $locationUrl['gscAdmin'],
            ],
            4 => [
                'id' => 2002,
                'shortname' => 'gc',
                'name' => __('Google Cache', $TEXTDOMAIN),
                'status' => 1,
                'url' => $locationUrl['gc'],
                'adminurl' => $locationUrl['gcAdmin'],
            ],
            5 => [
                'id' => 2003,
                'shortname' => 'gi',
                'name' => __('Google Index', $TEXTDOMAIN),
                'status' => 1,
                'url' => $locationUrl['gi'],
                'adminurl' => $locationUrl['giAdmin'],
            ],
            6 => [
                'id' => 3001,
                'shortname' => 'twitter',
                'name' => __('Twitter Search', $TEXTDOMAIN),
                'status' => 1,
                'url' => $locationUrl['twitter'],
                'adminurl' => $locationUrl['twitterAdmin'],
            ],
            7 => [
                'id' => 3002,
                'shortname' => 'facebook',
                'name' => __('Facebook Search', $TEXTDOMAIN),
                'status' => 1,
                'url' => $locationUrl['facebook'],
                'adminurl' => $locationUrl['facebookAdmin'],
            ],
            8 => [
                'id' => 3003,
                'shortname' => 'hatena',
                'name' => __('Hatena Bookmark', $TEXTDOMAIN),
                'status' => 1,
                'url' => $locationUrl['hatena'],
                'adminurl' => $locationUrl['hatenaAdmin'],
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

        add_option('abt_locale', $locale);
    }

    function abt_delete_db() {
        global $wpdb;
        $tableName = $wpdb->prefix . 'abt';
    
        delete_option('abt_locale');

        $sql = "DROP TABLE $tableName;";
        $wpdb->query($sql);
    }