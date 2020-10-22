<?php

    add_action('admin_menu', 'abt_addMenu');

    function abt_addMenu() {
        $TEXTDOMAIN = 'admin-bar-tools';

        add_options_page(
            __('Admin Bar Tools Setting', $TEXTDOMAIN),
            __('Admin Bar Tools Setting', $TEXTDOMAIN),
            'administrator',
            'admin-bar-tools-settings',
            'abt_settings_page'
        );
    };

    function add_settings_links ( $links ) {
        $TEXTDOMAIN = 'admin-bar-tools';

        $add_link = '<a href="options-general.php?page=admin-bar-tools-settings">' . __('Settings', $TEXTDOMAIN) . '</a>';
        array_unshift( $links, $add_link);
        return $links;
    };

    function abt_settings_page() {

        if(!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.', $TEXTDOMAIN));
        };

        global $wpdb;
        $tableName = $wpdb->prefix . 'abt';

        $result = $wpdb->get_results("SELECT * FROM $tableName");
        $resultName = array_column($result, 'name');

        $hiddenFieldName = 'hiddenStatus';

        $TEXTDOMAIN = 'admin-bar-tools';

        // $currentLocale = get_option('locale');

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
            };
        };
?>
    <div class="wrap">
    <?php if(isset($_POST[$hiddenFieldName]) && $_POST[$hiddenFieldName] === 'Y') : ?>
        <?php if(check_admin_referer('abt_settings_nonce', 'abt_settings_nonce')) : ?>
        <div class="updated">
            <p><?= __('Update is successful!!', $TEXTDOMAIN) ?></p>
            <p><?= __('Please reload once for the settings to take effect(Windows is F5 key, Mac is ⌘ key + R key).', $TEXTDOMAIN) ?></p>
        </div>
        <?php else : ?>
        <div class="error">
            <p><?= __('An error has occurred. Please try again.', $TEXTDOMAIN) ?></p>
        </div>
        <?php endif ?>
    <?php endif ?>
        <h1><?= __('Admin Bar Tools Settings', $TEXTDOMAIN) ?></h1>
        <h2><?= __('Please select the menu you want to display.', $TEXTDOMAIN) ?></h2>
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
            <p class="submit">
                <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
            </p>
        </form>
    </div>
<?php
    };