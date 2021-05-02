<?php
/**
 * Functions related to connecting to the database
 *
 * @author Ken-chan
 * @package WordPress
 * @subpackage Admin Bar Tools
 * @since 0.0.1
 */

declare( strict_types = 1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'You do not have access rights.' );
}

/**
 * Handle database connection.
 */
class Abt_Connect_Database {

	/**
	 * Table name.
	 *
	 * @var string
	 */
	private $table_name;

	/**
	 * Gave prefix.
	 */
	public function __construct() {
		global $wpdb;
		$this->table_name = $wpdb->prefix . Abt_Return_Data::TABLE_NAME;
	}

	/**
	 * Search Tables.
	 */
	public function abt_search_table() {
		global $wpdb;
		$current_db_version = get_option( 'abt_db_version' );
		$get_table          = $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $this->table_name ) ); // db call ok; no-cache ok.
		if ( $get_table !== $this->table_name || Abt_Return_Data::DB_VERSION !== $current_db_version ) {
			$this->abt_create_db();
		}
	}

	/**
	 * Create Table.
	 */
	private function abt_create_db() {
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $this->table_name (
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
	public function abt_default_insert_db() {
		global $wpdb;

		$locale       = get_locale();
		$make_db_data = Abt_Return_Data::make_table_data();

		foreach ( $make_db_data as $key => $value ) {
			$wpdb->insert(
				$this->table_name,
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
			); // db call ok; no-cache ok.
		};

		update_option( 'abt_locale', $locale );
	}

	/**
	 * Delete table.
	 */
	public static function abt_delete_db() {
		global $wpdb;
		$delete_table_name = $wpdb->prefix . Abt_Return_Data::TABLE_NAME;

		$sql = 'DROP TABLE IF EXISTS ' . $delete_table_name;
		$wpdb->query( "${sql}" ); // db call ok; no-cache ok.

		delete_option( 'abt_locale' );
		delete_option( 'abt_db_version' );
	}

	/**
	 * Return select table data.
	 *
	 * @param string $str SQL.
	 * @return array $result Result.
	 */
	public function return_table_data( string $str ): array {
		global $wpdb;
		$table_name = $wpdb->prefix . $str;
		$result     = $wpdb->get_results( "SELECT * FROM ${table_name}" ); // db call ok; no-cache ok.

		return $result;
	}
}
