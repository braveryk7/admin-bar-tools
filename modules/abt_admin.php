<?php

    add_action('admin_menu', 'abt_addMenu');

    function abt_addMenu() {
        add_menu_page(
            'Admin Bar Links',
            'Admin Bar Links',
            'administrator',
            '__FILE__',
            'abt_settings_page',
            'dashicons-smiley'
        );

        // add_actions('admin_init', 'abt_Settings');
    }

    function abt_settings_page() {

        if(!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        };

        global $wpdb;
        $tableName = $wpdb->prefix . 'abt';

        $result = $wpdb->get_results("SELECT * FROM $tableName");
        $resultName = array_column($result, 'name');

        $hiddenFieldName = 'hiddenStatus';

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
?>
    <div class="wrap">
        <?php if(isset($_POST[$hiddenFieldName]) && $_POST[$hiddenFieldName] === 'Y') : ?>
            <div class="updated">
                <p>Update is successful!!</p>
                <p>Please reload once for the settings to take effect(Windows is F5 key, Mac is ⌘ key + R key).</p>
            </div>
        <?php endif ?>
        <h1>Admin Bar Links Settings</h1>
        <h2>Please select the menu you want to display.</h2>
        <form name="abt_settings_form" method="post">
            <input type="hidden" name="<?= $hiddenFieldName ?>" value="Y">
            <?php foreach ($result as $key => $value) : ?>
            <p>
                <label>
                    <input type="checkbox" name="checkStatus[]" value="<?= $value->name ?>" <?= $value->status === '0' ? '' : 'checked' ?>>
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
    }