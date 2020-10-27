<?php

    function abt_db() {
        global $wpdb;
        $tableName = $wpdb->prefix . Constant::TABLENAME;
        if($wpdb->get_var("SHOW TABLES LIKE '".$tableName."'") != $tableName) {
            abt_create_db();
        }
    }

    function abt_create_db() {
        global $wpdb;
        $dbVersion = '1.0';

        $tableName = $wpdb->prefix . Constant::TABLENAME;
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

        update_option('abt_db_version', $dbVersion);
    }

    function abt_default_insert_db() {
        global $wpdb;
        $tableName = $wpdb->prefix . Constant::TABLENAME;

        $locale = get_locale();
        $makeDbData = Constant::makeDbData();

        foreach($makeDbData as $key => $value) {
            $wpdb->insert(
                $tableName,
                [
                    'id' => $makeDbData[$key]['id'],
                    'shortname' => $makeDbData[$key]['shortname'],
                    'name' => $makeDbData[$key]['name'],
                    'status' => $makeDbData[$key]['status'],
                    'url' => $makeDbData[$key]['url'],
                    'adminurl' => $makeDbData[$key]['adminurl']
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

        update_option('abt_locale', $locale);
    }

    function abt_delete_db() {
        global $wpdb;
        $tableName = $wpdb->prefix . Constant::TABLENAME;
    
        delete_option('abt_locale');

        $sql = "DROP TABLE $tableName;";
        $wpdb->query($sql);
    }