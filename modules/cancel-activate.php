<?php
/**
 * Cancel activate.
 *
 * @author Ken-chan
 * @package WordPress
 * @subpackage Admin Bar Tools
 * @since 1.0.3
 */

/**
 * Return error message.
 */
function cancel_activate() {
	?>
<div class="error">
	<p><?php esc_html_e( '[Plugin error] Admin Bar Tools has been stopped because the PHP version is old.' ); ?></p>
	<p>
		<?php esc_html_e( 'Admin Bar Tools requires at least PHP 7.3.0 or later.' ); ?>
		<?php esc_html_e( 'Please upgrade PHP.' ); ?>
	</p>
	<p>
		<?php esc_html_e( 'Current PHP version:' ); ?>
		<?php echo PHP_VERSION; ?>
	</p>
</div>
	<?php
}
