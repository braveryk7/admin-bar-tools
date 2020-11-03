<?php
/**
 * Admin settings page.
 *
 * @author Ken-chan
 * @package WordPress
 * @subpackage Admin Bar Tools
 * @since 0.0.1
 */

declare( strict_types = 1 );

/**
 * Return admin settings page.
 */
class Abt_Admin_Settings_Page {
	/**
	 * CONSTRUCT!!
	 * WordPress Hook
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'abt_add_menu' ] );
	}

	/**
	 * Add Admin Bar Tools to admin bar
	 */
	public function abt_add_menu() {
		add_options_page(
			__( 'Admin Bar Tools', 'admin-bar-tools' ),
			__( 'Admin Bar Tools', 'admin-bar-tools' ),
			'administrator',
			'admin-bar-tools-settings',
			[ $this, 'abt_settings_page' ]
		);
	}

	/**
	 * Add configuration link to plugin page
	 *
	 * @param array|string $links plugin page setting links.
	 */
	public function add_settings_links( array $links ): array {
		$add_link = '<a href="options-general.php?page=admin-bar-tools-settings">' . __( 'Settings', 'admin-bar-tools' ) . '</a>';
		array_unshift( $links, $add_link );
		return $links;
	}

	/**
	 * Settings Page
	 */
	public function abt_settings_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'admin-bar-tools' ) );
		};

		global $wpdb;
		$table_name = $wpdb->prefix . Abt_Return_Data::TABLE_NAME;

		$result      = $wpdb->get_results( "SELECT * FROM ${table_name}" ); // db call ok; no-cache ok.
		$result_name = array_column( $result, 'name' );

		$hidden_field_name = 'hiddenStatus';

		if ( isset( $_POST[ $hidden_field_name ] ) && 'Y' === $_POST[ $hidden_field_name ] ) {
			if ( check_admin_referer( 'abt_settings_nonce', 'abt_settings_nonce' ) ) {
				foreach ( $result_name as $value ) {
					if ( isset( $_POST['checkStatus'] ) && in_array( $value, $_POST['checkStatus'], true ) ) {
						$wpdb->update(
							$table_name,
							[ 'status' => 1 ],
							[ 'name' => $value ],
							[ '%d' ],
							[ '%s' ],
						); // db call ok; no-cache ok.
					} else {
						$wpdb->update(
							$table_name,
							[ 'status' => 0 ],
							[ 'name' => $value ],
							[ '%d' ],
							[ '%s' ],
						); // db call ok; no-cache ok.
					};
				};
				$result = $wpdb->get_results( "SELECT * FROM ${table_name}" ); // db call ok; no-cache ok.

				$locale = get_option( 'abt_locale' );

				if ( isset( $_POST['localeSettings'] ) && $_POST['localeSettings'] !== $locale ) {
					$post_locale       = sanitize_text_field( wp_unslash( $_POST['localeSettings'] ) );
					$new_location_urls = Abt_Return_Data::change_locale( $post_locale );
					foreach ( $new_location_urls as $key => $value ) {
						$wpdb->update(
							$table_name,
							[
								'url'      => $new_location_urls[ $key ]['url'],
								'adminurl' => $new_location_urls[ $key ]['adminurl'],
							],
							[ 'shortname' => $new_location_urls[ $key ]['shortname'] ],
							[ '%s' ],
							[ '%s' ],
						); // db call ok; no-cache ok.
					};
					update_option( 'abt_locale', $post_locale );
				}
			};

		};
		?>
<div class="wrap">
		<?php if ( isset( $_POST[ $hidden_field_name ] ) && 'Y' === $_POST[ $hidden_field_name ] ) : ?>
			<?php if ( check_admin_referer( 'abt_settings_nonce', 'abt_settings_nonce' ) ) : ?>
	<div class="updated">
		<p><?php esc_html_e( 'Update is successful!!', 'admin-bar-tools' ); ?></p>
		<p><?php esc_html_e( 'Please reload once for the settings to take effect(Windows is F5 key, Mac is ⌘ key + R key).', 'admin-bar-tools' ); ?></p>
	</div>
			<?php else : ?>
	<div class="error">
		<p><?php esc_html_e( 'An error has occurred. Please try again.', 'admin-bar-tools' ); ?></p>
	</div>
			<?php endif ?>
		<?php endif ?>
	<h1><?php esc_html_e( 'Admin Bar Tools Settings', 'admin-bar-tools' ); ?></h1>
	<h2><?php esc_html_e( 'Please select the menu you want to display.', 'admin-bar-tools' ); ?></h2>
	<form name="abt_settings_form" method="post">
		<input type="hidden" name="<?php echo esc_attr( $hidden_field_name ); ?>" value="Y">
		<?php wp_nonce_field( 'abt_settings_nonce', 'abt_settings_nonce' ); ?>
		<?php foreach ( $result as $key => $value ) : ?>
		<p>
			<label>
				<input type="checkbox" name="checkStatus[]" value="<?php echo esc_attr( $value->name ); ?>" <?php echo '0' === $value->status ? '' : 'checked'; ?>>
				<?php echo esc_html( $value->name ); ?>
			</label>
		</p>
		<?php endforeach ?>
		<p><?php esc_html_e( 'Locale/Language', 'admin-bar-tools' ); ?>:
			<select name="localeSettings">
				<option value="en_US"><?php esc_html_e( 'English(United States)', 'admin-bar-tools' ); ?></option>
				<option value="ja" <?php echo 'ja' === get_option( 'abt_locale' ) ? 'selected' : ''; ?>><?php esc_html_e( 'Japanese', 'admin-bar-tools' ); ?></option>
			</select>
		</p>
		<p class="submit">
			<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes' ); ?>" />
		</p>
	</form>
</div>
		<?php
	}
}

if ( is_admin() ) {
	$settings_page = new Abt_Admin_Settings_Page();
}
