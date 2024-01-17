<?php
/**
 * Database function tests.
 *
 * @package Flush_Transients\Tests
 * @author Felix Arntz <hello@felix-arntz.me>
 */

class Flush_Transients_DB_Tests extends WP_UnitTestCase {

	public function test_hooks() {
		$this->assertSame( 10, has_action( 'setted_transient', 'flush_transients_invalidate_caches' ) );
		$this->assertSame( 10, has_action( 'deleted_transient', 'flush_transients_invalidate_caches' ) );
		$this->assertSame( 10, has_action( 'setted_site_transient', 'flush_transients_invalidate_caches' ) );
		$this->assertSame( 10, has_action( 'deleted_site_transient', 'flush_transients_invalidate_caches' ) );
	}

	public function test_flush_transients_flush_db_transients_regular() {
		$sample_transients = $this->get_sample_transients();
		foreach ( $sample_transients as $transient => $value ) {
			set_transient( $transient, $value );
		}

		$before_flush = array();
		foreach ( array_keys( $sample_transients ) as $transient ) {
			$before_flush[ $transient ] = get_transient( $transient );
		}
		$before_flush = array_filter( $before_flush );
		$this->assertCount( count( $sample_transients ), $before_flush );

		flush_transients_flush_db_transients( 'regular' );

		$after_flush = array();
		foreach ( array_keys( $sample_transients ) as $transient ) {
			$after_flush[ $transient ] = get_transient( $transient );
		}
		$after_flush = array_filter( $after_flush );
		$this->assertCount( 0, $after_flush );
	}

	public function test_flush_transients_flush_db_transients_network() {
		$sample_transients = $this->get_sample_transients();
		foreach ( $sample_transients as $transient => $value ) {
			set_site_transient( $transient, $value );
		}

		$before_flush = array();
		foreach ( array_keys( $sample_transients ) as $transient ) {
			$before_flush[ $transient ] = get_site_transient( $transient );
		}
		$before_flush = array_filter( $before_flush );
		$this->assertCount( count( $sample_transients ), $before_flush );

		flush_transients_flush_db_transients( 'network' );

		$after_flush = array();
		foreach ( array_keys( $sample_transients ) as $transient ) {
			$after_flush[ $transient ] = get_site_transient( $transient );
		}
		$after_flush = array_filter( $after_flush );
		$this->assertCount( 0, $after_flush );
	}

	public function test_flush_transients_query_db_transient_count_regular() {
		$initial_count = flush_transients_query_db_transient_count( 'regular' );

		$sample_transients = $this->get_sample_transients();
		foreach ( $sample_transients as $transient => $value ) {
			set_transient( $transient, $value );
		}

		$new_count = flush_transients_query_db_transient_count( 'regular' );
		$this->assertSame( $initial_count + count( $sample_transients ), $new_count );
	}

	public function test_flush_transients_query_db_transient_count_network() {
		$initial_count = flush_transients_query_db_transient_count( 'network' );

		$sample_transients = $this->get_sample_transients();
		foreach ( $sample_transients as $transient => $value ) {
			set_site_transient( $transient, $value );
		}

		$new_count = flush_transients_query_db_transient_count( 'network' );
		$this->assertSame( $initial_count + count( $sample_transients ), $new_count );
	}

	public function test_flush_transients_invalidate_caches() {
		wp_cache_set( 'regular_transient_count', 21, 'flush_transients' );
		wp_cache_set( 'network_transient_count', 23, 'flush_transients' );

		flush_transients_invalidate_caches();

		$this->assertFalse( wp_cache_get( 'regular_transient_count', 'flush_transients' ) );
		$this->assertFalse( wp_cache_get( 'network_transient_count', 'flush_transients' ) );
	}

	private function get_sample_transients() {
		$samples = array();
		for ( $i = 0; $i < 30; $i++ ) {
			$samples[ "some_cache_{$i}" ] = "value for {$i}";
		}
		return $samples;
	}
}
