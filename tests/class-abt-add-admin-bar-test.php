<?php
declare( strict_types = 1 );

use Yoast\WPTestUtils\WPIntegration\TestCase;
/**
 * Test: Abt_Add_Admin_Bar
 */
class Abt_Add_Admin_Bar_Test extends TestCase {
	/**
	 * This test class instance.
	 *
	 * @var object $instance instance.
	 */
	private $instance;

	/**
	 * Settings: ABSPATH, test class file, WordPress functions.
	 */
	public static function set_up_before_class(): void {
		if ( ! class_exists( 'Abt_Base' ) ) {
			require_once ROOT_DIR . '/class/class-abt-base.php';
		}

		require_once ROOT_DIR . '/class/class-abt-add-admin-bar.php';
	}

	/**
	 * SetUp.
	 * Create instance.
	 */
	public function set_up() :void {
		parent::set_up();
		$this->instance = new Abt_Add_Admin_Bar();
	}

	/**
	 * TEST: add_admin_bar()
	 *
	 * @testWith [ "psi" ]
	 *           [ "lh" ]
	 *           [ "gsc" ]
	 *           [ "gc" ]
	 *           [ "gi" ]
	 *           [ "bi" ]
	 *           [ "twitter" ]
	 *           [ "facebook" ]
	 *           [ "hatena" ]
	 *
	 * @param string $expected expected.
	 */
	public function test_add_admin_bar( string $expected ): void {
		wp_set_current_user( null, 'admin' );

		require_once ABSPATH . 'wp-includes/class-wp-admin-bar.php';

		$wp_admin_bar = new WP_Admin_Bar();
		$wp_admin_bar->initialize();

		$this->instance->add_admin_bar( $wp_admin_bar );
		$wp_admin_bar_nodes = $wp_admin_bar->get_nodes();
		$this->assertArrayHasKey( $expected, $wp_admin_bar_nodes );
	}

	/**
	 * TEST: searchconsole_url()
	 *
	 * @testWith [ 1 ]
	 *           [ 2 ]
	 *
	 * @param int $status status.
	 */
	public function test_searchconsole_url( int $status ): void {
		$method = new ReflectionMethod( $this->instance, 'searchconsole_url' );
		$method->setAccessible( true );

		$post_id = $this->factory()->post->create();
		$url     = get_permalink( $post_id );
		$this->go_to( $url );

		$search_console_url = 'https://search.google.com/search-console';

		$generate_url = function ( $status ) {
			$encode_url = rawurlencode( get_pagenum_link( get_query_var( 'paged' ) ) );
			$domain     = isset( $_SERVER['SERVER_NAME'] ) ? sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) ) : '';
			$parameter  = [
				'?resource_id=sc-domain:',
				'/performance/search-analytics?resource_id=sc-domain:',
			];

			return match ( $status ) {
				1       => is_front_page() ? $parameter[0] . $domain : $parameter[1] . $domain . '&page=!' . $encode_url,
				2       => is_front_page() ? $parameter[0] . $encode_url : $parameter[1] . rawurlencode( $domain . '/' ) . '&page=!' . $encode_url,
				default => null,
			};
		};

		$expected = $search_console_url . $generate_url( $status );

		$this->assertSame( $expected, $method->invoke( $this->instance, $search_console_url, $status, rawurlencode( get_pagenum_link( get_query_var( 'paged' ) ) ) ) );
	}

	/**
	 * TEST: add_theme_support_link()
	 *
	 * @testWith [ "abt_theme_support", "abt" ]
	 *           [ "official", "abt_theme_support" ]
	 *           [ "manual", "abt_theme_support" ]
	 *           [ "forum", "abt_theme_support" ]
	 *
	 * @param string $id     node id.
	 * @param string $parent node parent.
	 */
	public function test_add_theme_support_link( string $id, string $parent ): void {
		$wp_admin_bar = new WP_Admin_Bar();
		$wp_admin_bar->initialize();

		switch_theme( 'cocoon-master' );
		$this->instance->add_theme_support_link( $wp_admin_bar );

		$this->assertArrayHasKey( $id, $wp_admin_bar->get_nodes() );

		$node = $wp_admin_bar->get_node( $id );
		isset( $node->parent ) ? $this->assertSame( $parent, $node->parent ) : $this->fail( "Node with id {$id} not found" );
	}
}
