<?php
/**
 * UI function tests.
 *
 * @package Flush_Transients\Tests
 * @author Felix Arntz <hello@felix-arntz.me>
 */

class Flush_Transients_UI_Tests extends WP_UnitTestCase {

	public function test_hooks() {
		$this->assertSame( 10, has_action( 'admin_action_flush_transients', 'flush_transients_handle_flush_action' ) );
		$this->assertSame( 10, has_action( 'admin_notices', 'flush_transients_admin_notice' ) );
		$this->assertSame( 10, has_action( 'network_admin_notices', 'flush_transients_admin_notice' ) );
		$this->assertSame( 10, has_action( 'admin_bar_menu', 'flush_transients_admin_bar_menu' ) );
	}
}
