<?php
/**
 * Database functions and hooks.
 *
 * @package Flush_Transients
 * @author Felix Arntz <hello@felix-arntz.me>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Flushes all transients stored in the database.
 *
 * This method is only relevant when not using a persistent object cache.
 *
 * @since 1.0.0
 *
 * @global wpdb $wpdb WordPress database abstraction object
 *
 * @param string $type Optional. Which type of transient to flush. Either 'regular' or 'network'. Default 'regular'.
 * @return bool True on success, false on failure.
 */
function flush_transients_flush_db_transients( $type = 'regular' ) {
	global $wpdb;

	$table_name       = is_multisite() && 'network' === $type ? $wpdb->sitemeta : $wpdb->options;
	$table_column     = is_multisite() && 'network' === $type ? 'meta_key' : 'option_name';
	$transient_prefix = 'network' === $type ? '_site_transient_' : '_transient_';
	$timeout_prefix   = 'network' === $type ? '_site_transient_timeout_' : '_transient_timeout_';

	$result = $wpdb->query(
		$wpdb->prepare(
			"SELECT COUNT({$table_column}) FROM {$table_name} WHERE {$table_column} LIKE %s AND {$table_column} NOT LIKE %s",
			$wpdb->esc_like( $transient_prefix ) . '%',
			$wpdb->esc_like( $timeout_prefix ) . '%'
		)
	);

	flush_transients_invalidate_caches();

	return false !== $result ? true : false;
}

/**
 * Runs a query to get the amount of transients stored in the database.
 *
 * This method is only relevant when not using a persistent object cache.
 *
 * @since 1.0.0
 *
 * @global wpdb $wpdb WordPress database abstraction object
 *
 * @param string $type Optional. Which type of transient to query. Either 'regular' or 'network'. Default 'regular'.
 * @return int Number of transients.
 */
function flush_transients_query_db_transient_count( $type = 'regular' ) {
	global $wpdb;

	$transient_count = wp_cache_get( "{$type}_transient_count", 'flush_transients' );
	if ( false !== $transient_count ) {
		return (int) $transient_count;
	}

	$table_name       = is_multisite() && 'network' === $type ? $wpdb->sitemeta : $wpdb->options;
	$table_column     = is_multisite() && 'network' === $type ? 'meta_key' : 'option_name';
	$transient_prefix = 'network' === $type ? '_site_transient_' : '_transient_';
	$timeout_prefix   = 'network' === $type ? '_site_transient_timeout_' : '_transient_timeout_';

	$transient_count = (int) $wpdb->get_var(
		$wpdb->prepare(
			"SELECT COUNT({$table_column}) FROM {$table_name} WHERE {$table_column} LIKE %s AND {$table_column} NOT LIKE %s",
			$wpdb->esc_like( $transient_prefix ) . '%',
			$wpdb->esc_like( $timeout_prefix ) . '%'
		)
	);

	wp_cache_set( "{$type}_transient_count", $transient_count, 'flush_transients' );

	return $transient_count;
}

/**
 * Invalidates the caches for transient counts of all types.
 *
 * This method is only relevant when not using a persistent object cache.
 *
 * @since 1.0.0
 */
function flush_transients_invalidate_caches() {
	if ( function_exists( 'wp_cache_flush_group' ) && function_exists( 'wp_cache_supports' ) && wp_cache_supports( 'flush_group' ) ) {
		wp_cache_flush_group( 'flush_transients' );
		return;
	}

	wp_cache_delete( 'regular_transient_count', 'flush_transients' );
	wp_cache_delete( 'network_transient_count', 'flush_transients' );
}
add_action( 'setted_transient', 'flush_transients_invalidate_caches' );
add_action( 'deleted_transient', 'flush_transients_invalidate_caches' );
add_action( 'setted_site_transient', 'flush_transients_invalidate_caches' );
add_action( 'deleted_site_transient', 'flush_transients_invalidate_caches' );
