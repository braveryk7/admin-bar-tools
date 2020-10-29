<?php

    class AdminSettings {
        function __construct() {
            add_action('admin_menu', [$this, 'abt_addMenu']);
        }

        function abt_addMenu() {
            add_options_page(
                __('Admin Bar Tools Setting', Constant::TEXT_DOMAIN),
                __('Admin Bar Tools Setting', Constant::TEXT_DOMAIN),
                'administrator',
                'admin-bar-tools-settings',
                [$this, 'abt_settings_page']
            );
        }

        function add_settings_links ( $links ) {
            $add_link = '<a href="options-general.php?page=admin-bar-tools-settings">' . __('Settings', Constant::TEXT_DOMAIN) . '</a>';
            array_unshift( $links, $add_link);
            return $links;
        }

        function abt_settings_page() {
            if(!current_user_can('manage_options')) {
                wp_die(__('You do not have sufficient permissions to access this page.', Constant::TEXT_DOMAIN));
            };

            global $wpdb;
            $tableName = $wpdb->prefix . Constant::TABLE_NAME;

            $result = $wpdb->get_results("SELECT * FROM $tableName");
            $resultName = array_column($result, 'name');

            $hiddenFieldName = 'hiddenStatus';

            if(isset($_POST[$hiddenFieldName]) && $_POST[$hiddenFieldName] === 'Y') {
                if(check_admin_referer('abt_settings_nonce', 'abt_settings_nonce')) {
                    foreach($resultName as $value) {
                        if(in_array($value, $_POST['checkStatus'], true)) {                    
                            $wpdb->update(
                                $tableName,
                                ['status' => 1],
                                ['name' => $value],
                                ['%d'],
                                ['%s']
                            );
                        } else {                   
                            $wpdb->update(
                                $tableName,
                                ['status' => 0],
                                ['name' => $value],
                                ['%d'],
                                ['%s']
                            );
                        };
                    };
                    $result = $wpdb->get_results("SELECT * FROM $tableName");
                
                    $locale = get_option('abt_locale');
    
                    if($_POST['localeSettings'] !== $locale) {
                        $newLocationUrls = Constant::change_locale($_POST['localeSettings']);
                        foreach($newLocationUrls as $key => $value) {
                            $wpdb->update(
                                $tableName,
                                [
                                    'url' => $newLocationUrls[$key]['url'],
                                    'adminurl' => $newLocationUrls[$key]['adminurl']
                                ],
                                ['shortname' => $newLocationUrls[$key]['shortname']],
                                ['%s'],
                                ['%s']
                            );
                        };
                        update_option('abt_locale', $_POST['localeSettings']);
                    }
                };

            };
?>
    <div class="wrap">
    <?php if(isset($_POST[$hiddenFieldName]) && $_POST[$hiddenFieldName] === 'Y') : ?>
        <?php if(check_admin_referer('abt_settings_nonce', 'abt_settings_nonce')) : ?>
        <div class="updated">
            <p><?= __('Update is successful!!', Constant::TEXT_DOMAIN) ?></p>
            <p><?= __('Please reload once for the settings to take effect(Windows is F5 key, Mac is ⌘ key + R key).', Constant::TEXT_DOMAIN) ?></p>
        </div>
        <?php else : ?>
        <div class="error">
            <p><?= __('An error has occurred. Please try again.', Constant::TEXT_DOMAIN) ?></p>
        </div>
        <?php endif ?>
    <?php endif ?>
        <h1><?= __('Admin Bar Tools Settings', Constant::TEXT_DOMAIN) ?></h1>
        <h2><?= __('Please select the menu you want to display.', Constant::TEXT_DOMAIN) ?></h2>
        <form name="abt_settings_form" method="post">
            <input type="hidden" name="<?= esc_attr__($hiddenFieldName) ?>" value="Y">
            <?php wp_nonce_field('abt_settings_nonce', 'abt_settings_nonce') ?>
            <?php foreach ($result as $key => $value) : ?>
            <p>
                <label>
                    <input type="checkbox" name="checkStatus[]" value="<?= esc_attr__($value->name) ?>" <?= $value->status === '0' ? '' : 'checked' ?>>
                    <?= $value->name ?>
                </label>
            </p>
            <?php endforeach ?>
            <p><?= __('Locale/Language', Constant::TEXT_DOMAIN) ?>:
                <select name="localeSettings">
                    <option value="en_US"><?= __('English(United States)', Constant::TEXT_DOMAIN) ?></option>
                    <option value="ja" <?php if(get_option('abt_locale') === 'ja') echo 'selected' ?>><?= __('Japanese', Constant::TEXT_DOMAIN) ?></option>
                </select>
            </p>
            <p class="submit">
                <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
            </p>
        </form>
    </div>
<?php
        }
    }

    if(is_admin()) {
        $settingsPage = new AdminSettings();
    }