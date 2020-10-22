<?php

    add_action('admin_menu', 'abt_addMenu');

    function abt_addMenu() {
        add_menu_page(
            'Admin Bar Tools',
            'Admin Bar Tools',
            'administrator',
            '__FILE__',
            'abt_settings_page',
            'dashicons-smiley'
        );
    };

    function abt_settings_page() {

        if(!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        };

        global $wpdb;
        $tableName = $wpdb->prefix . 'abt';

        $result = $wpdb->get_results("SELECT * FROM $tableName");
        $resultName = array_column($result, 'name');

        $hiddenFieldName = 'hiddenStatus';

        // $currentLocale = get_option('locale');

        if(isset($_POST[$hiddenFieldName]) && $_POST[$hiddenFieldName] === 'Y') {
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

        $TEXTDOMAIN = 'admin-bar-tools';
?>
    <div class="wrap">
        <?php if(isset($_POST[$hiddenFieldName]) && $_POST[$hiddenFieldName] === 'Y') : ?>
            <div class="updated">
                <p><?= __('Update is successful!!', $TEXTDOMAIN) ?></p>
                <p><?= __('Please reload once for the settings to take effect(Windows is F5 key, Mac is ⌘ key + R key).', $TEXTDOMAIN) ?></p>
            </div>
        <?php endif ?>
        <h1><?= __('Admin Bar Tools Settings', $TEXTDOMAIN) ?></h1>
        <h2><?= __('Please select the menu you want to display.', $TEXTDOMAIN) ?></h2>
        <form name="abt_settings_form" method="post">
            <input type="hidden" name="<?= esc_attr__($hiddenFieldName) ?>" value="Y">
            <?php foreach ($result as $key => $value) : ?>
            <p>
                <label>
                    <input type="checkbox" name="checkStatus[]" value="<?= esc_attr__($value->name) ?>" <?= $value->status === '0' ? '' : 'checked' ?>>
                    <?= $value->name ?>
                </label>
            </p>
            <?php endforeach; ?>
            <p class="submit">
                <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
            </p>

        </form>
    </div>
<?php
    };