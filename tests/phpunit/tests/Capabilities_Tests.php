<?php
/**
 * Capability function tests.
 *
 * @package Flush_Transients\Tests
 * @author Felix Arntz <hello@felix-arntz.me>
 */

class Flush_Transients_Capabilities_Tests extends WP_UnitTestCase {

	public static $admin_id;

	public static function wpSetUpBeforeClass( WP_UnitTest_Factory $factory ) {
		self::$admin_id = $factory->user->create( array( 'role' => 'administrator' ) );
	}

	public static function wpTearDownAfterClass() {
		if ( is_multisite() ) {
			wpmu_delete_user( self::$admin_id );
		} else {
			wp_delete_user( self::$admin_id );
		}
	}

	public function test_hooks() {
		$this->assertSame( 10, has_filter( 'user_has_cap', 'flush_transients_grant_cap' ) );
	}

	public function test_flush_transients_can_flush_transients_regular() {
		$this->assertFalse( flush_transients_can_flush_transients( 'regular' ) );

		wp_set_current_user( self::$admin_id );

		$this->assertTrue( flush_transients_can_flush_transients( 'regular' ) );
	}

	public function test_flush_transients_can_flush_transients_network() {
		$this->assertFalse( flush_transients_can_flush_transients( 'network' ) );

		wp_set_current_user( self::$admin_id );

		if ( is_multisite() ) {
			$this->assertFalse( flush_transients_can_flush_transients( 'network' ) );

			grant_super_admin( self::$admin_id );
		}

		$this->assertTrue( flush_transients_can_flush_transients( 'network' ) );
	}
}
