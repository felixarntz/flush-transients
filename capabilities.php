<?php
/**
 * Capability functions and hooks.
 *
 * @package Flush_Transients
 * @author Felix Arntz <hello@felix-arntz.me>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Checks whether the current user can flush transients.
 *
 * @since 1.0.0
 *
 * @param string $type Optional. Which type of transient to flush. Either 'regular' or 'network'. Default 'regular'.
 * @return bool True if the current user has the necessary capabilities, false otherwise.
 */
function flush_transients_can_flush_transients( $type = 'regular' ) {
	/*
	 * A separate capability is only relevant when using WordPress Multisite.
	 * Otherwise, network transients are still stored for the site.
	 */
	if ( is_multisite() && 'network' === $type ) {
		return current_user_can( 'flush_network_transients' );
	}

	return current_user_can( 'flush_transients' );
}

/**
 * Grants the 'flush_transients' capability to users with the 'manage_options' capability.
 *
 * @since 1.0.0
 *
 * @param array $allcaps Map of $capability => $grant pairs.
 * @return array Filtered $allcaps.
 */
function flush_transients_grant_cap( $allcaps ) {
	if ( isset( $allcaps['manage_options'] ) ) {
		$allcaps['flush_transients'] = $allcaps['manage_options'];
	}
	return $allcaps;
}
add_filter( 'user_has_cap', 'flush_transients_grant_cap' );
