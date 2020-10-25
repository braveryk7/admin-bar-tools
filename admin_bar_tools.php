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

        static $locale;
        private $psiUrl;
        private $psiAdminUrl;
        public static $locationUrl = [];

        function __construct() {

            self::$locale = get_locale();
            if(self::$locale === 'ja') {
                $this->psiUrl = 'https://developers.google.com/speed/pagespeed/insights/?hl=JA&url=';
                $this->psiAdminUrl = 'https://developers.google.com/speed/pagespeed/insights/?hl=JA';
            } else {
                $this->psiUrl = 'https://developers.google.com/speed/pagespeed/insights/?hl=US&url=';
                $this->psiAdminUrl = 'https://developers.google.com/speed/pagespeed/insights/?hl=US';
            }
            self::$locationUrl += [
                'psi' => $this->psiUrl,
                'psiAdmin' => $this->psiAdminUrl,
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
        }
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