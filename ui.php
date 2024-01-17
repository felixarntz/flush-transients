<?php
/**
 * UI functions and hooks.
 *
 * @package Flush_Transients
 * @author Felix Arntz <hello@felix-arntz.me>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Handles the admin action to flush transients.
 *
 * @since 1.0.0
 * @access private
 */
function flush_transients_handle_flush_action() {
	check_admin_referer( 'flush_transients' );

	$type = 'regular';
	if ( isset( $_REQUEST['type'] ) && 'network' === $_REQUEST['type'] ) {
		$type = 'network';
	}

	if ( ! flush_transients_can_flush_transients( $type ) ) {
		wp_die( esc_html__( 'Sorry, you are not allowed to flush transients.', 'flush-transients' ), '', 403 );
	}

	$result = 'error';

	if ( wp_using_ext_object_cache() ) {
		$cache_group = 'network' === $type ? 'site_transient' : 'transient';
		if ( function_exists( 'wp_cache_flush_group' ) && function_exists( 'wp_cache_supports' ) && wp_cache_supports( 'flush_group' ) ) {
			wp_cache_flush_group( $cache_group );
			$result = 'success';
		}

		wp_safe_redirect( add_query_arg( 'flush_transient_result', $result, wp_get_referer() ) );
		exit;
	}

	if ( flush_transients_flush_db_transients( $type ) ) {
		$result = 'success';
	}

	wp_safe_redirect( add_query_arg( 'flush_transient_result', $result, wp_get_referer() ) );
	exit;
}
add_action( 'admin_action_flush_transients', 'flush_transients_handle_flush_action' );

/**
 * Renders an admin notice with the result of the flush transients action.
 *
 * @since 1.0.0
 * @access private
 */
function flush_transients_admin_notice() {
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	if ( empty( $_REQUEST['flush_transient_result'] ) ) {
		return;
	}

	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$result = 'error' === $_REQUEST['flush_transient_result'] ? 'error' : 'success';
	if ( 'error' === $result && wp_using_ext_object_cache() ) {
		$message  = __( 'Flushing transients in the object cache failed.', 'flush-transients' );
		$message .= '<br>';
		$message .= __( 'This is most likely because your object cache implementation does not support flushing cache groups.', 'flush-transients' );
	} elseif ( 'error' === $result ) {
		$message = __( 'Flushing transients in the database failed.', 'flush-transients' );
	} else {
		$message = __( 'Transients flushed.', 'flush-transients' );
	}

	?>
	<div class="<?php echo esc_attr( "notice notice-{$result} is-dismissible" ); ?>">
		<p><?php echo wp_kses( $message, array( 'br' => array() ) ); ?></p>
	</div>
	<?php
}
add_action( 'admin_notices', 'flush_transients_admin_notice' );
add_action( 'network_admin_notices', 'flush_transients_admin_notice' );

/**
 * Adds the admin bar menu to flush transients.
 *
 * @since 1.0.0
 * @access private
 *
 * @param WP_Admin_Bar $admin_bar The admin bar object.
 */
function flush_transients_admin_bar_menu( $admin_bar ) {
	$type = is_network_admin() ? 'network' : 'regular';

	if ( ! flush_transients_can_flush_transients( $type ) ) {
		return;
	}

	$action_url_args = array(
		'action'           => 'flush_transients',
		'type'             => $type,
		'_wpnonce'         => wp_create_nonce( 'flush_transients' ),
		'_wp_http_referer' => remove_query_arg( '_wp_http_referer' ),
	);

	if ( wp_using_ext_object_cache() ) {
		$title = is_network_admin() ? __( 'Flush network transients', 'flush-transients' ) : __( 'Flush transients', 'flush-transients' );
	} else {
		$transient_count = flush_transients_query_db_transient_count( $type );
		if ( is_network_admin() ) {
			/* translators: %s: number of transients */
			$title = sprintf( _n( 'Flush %s network transient', 'Flush %s network transients', $transient_count, 'flush-transients' ), $transient_count );
		} else {
			/* translators: %s: number of transients */
			$title = sprintf( _n( 'Flush %s transient', 'Flush %s transients', $transient_count, 'flush-transients' ), $transient_count );
		}
	}

	$base_url = is_network_admin() ? network_admin_url( 'index.php' ) : admin_url( 'index.php' );

	$admin_bar->add_node(
		array(
			'id'    => 'flush-transients',
			'title' => $title,
			'href'  => add_query_arg( $action_url_args, $base_url ),
		)
	);

	/*
	 * When not on a multisite, show another link to flush network transients.
	 * In this case they are stored in the database for the individual site as well.
	 */
	if ( ! is_multisite() ) {
		$action_url_args['type'] = 'network';

		if ( wp_using_ext_object_cache() ) {
			$title = __( 'Flush network transients', 'flush-transients' );
		} else {
			$transient_count = flush_transients_query_db_transient_count( 'network' );

			/* translators: %s: number of transients */
			$title = sprintf( _n( 'Flush %s network transient', 'Flush %s network transients', $transient_count, 'flush-transients' ), $transient_count );
		}

		$admin_bar->add_node(
			array(
				'parent' => 'flush-transients',
				'id'     => 'flush-transients-network',
				'title'  => $title,
				'href'   => add_query_arg( $action_url_args, $base_url ),
			)
		);
	}
}
add_action( 'admin_bar_menu', 'flush_transients_admin_bar_menu', 100 );
