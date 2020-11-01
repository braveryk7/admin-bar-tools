<?php
/**
 * Functions related to connecting to the database
 *
 * @package Admin Bar Tools
 * @author Ken-chan
 */

/**
 * Search Tables.
 */
function abt_db() {
	global $wpdb;
	$table_name = $wpdb->prefix . Abt_Return_Data::TABLE_NAME;
	if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table_name ) ) !== $table_name ) {
		abt_create_db();
	}
}

/**
 * Create Table.
 */
function abt_create_db() {
	global $wpdb;

	$table_name      = $wpdb->prefix . Abt_Return_Data::TABLE_NAME;
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id smallint(4) UNSIGNED NOT NULL PRIMARY KEY,
        shortname varchar(255) NOT NULL,
        name varchar(255) NOT NULL,
        status tinyint(1) UNSIGNED NOT NULL,
        url text NOT NULL,
        adminurl text NOT NULL
	) $charset_collate;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql );

	update_option( 'abt_db_version', Abt_Return_Data::DB_VERSION );
}

/**
 * Insert default records.
 */
function abt_default_insert_db() {
	global $wpdb;
	$table_name = $wpdb->prefix . Abt_Return_Data::TABLE_NAME;

	$locale       = get_locale();
	$make_db_data = Abt_Return_Data::make_table_data();

	foreach ( $make_db_data as $key => $value ) {
		$wpdb->insert(
			$table_name,
			[
				'id'        => $make_db_data[ $key ]['id'],
				'shortname' => $make_db_data[ $key ]['shortname'],
				'name'      => $make_db_data[ $key ]['name'],
				'status'    => $make_db_data[ $key ]['status'],
				'url'       => $make_db_data[ $key ]['url'],
				'adminurl'  => $make_db_data[ $key ]['adminurl'],
			],
			[
				'%d',
				'%s',
				'%s',
				'%d',
				'%s',
				'%s',
			]
		);
	};

	update_option( 'abt_locale', $locale );
}

/**
 * Delete table.
 */
function abt_delete_db() {
	global $wpdb;
	$table_name = $wpdb->prefix . Abt_Return_Data::TABLE_NAME;

	delete_option( 'abt_locale' );

	$wpdb->query( 'DROP TABLE IF EXISTS $table_name' );
}
