<?php

    add_action('admin_menu', 'abt_addMenu');

    function abt_addMenu() {
        add_menu_page(
            'Admin Bar Links',
            'Admin Bar Links',
            'administrator',
            '__FILE__',
            'abt_SettingsPage',
            'dashicons-smiley'
        );

        // add_actions('admin_init', 'abt_Settings');
    }

    function abt_SettingsPage() {
        global $wpdb;
        $tableName = $wpdb->prefix . 'abt';

        $result = $wpdb->get_results("SELECT * FROM $tableName");
?>
    <div class="wrap">
        <h1>Admin Bar Links Settings</h1>
        <h2>Please select the menu you want to display.</h2>
        <form name="abt_settings_form" method="post">
            <input type="hidden" name="" value="">
            <?php foreach ($result as $key => $value) : ?>
            <p>
                <label>
                    <input type="checkbox" name="" value="" <?= $value->status === '0' ? '' : 'checked' ?>>
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