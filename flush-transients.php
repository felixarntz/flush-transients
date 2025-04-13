<?php
/**
 * Plugin main file.
 *
 * @package Flush_Transients
 * @author Felix Arntz <hello@felix-arntz.me>
 *
 * @wordpress-plugin
 * Plugin Name: Flush Transients
 * Plugin URI: https://wordpress.org/plugins/flush-transients/
 * Description: This plugin allows you to flush WordPress transients, plain and simple.
 * Version: 1.0.1
 * Requires at least: 5.0
 * Requires PHP: 5.2
 * Author: Felix Arntz
 * Author URI: https://felix-arntz.me
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: flush-transients
 * Tags: transients, cache, flushing, invalidation, performance
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Retrieves the current WordPress version used on the site.
 *
 * @since 1.0.1
 */
function flush_transients_get_wp_version() {
	// Get unmodified `$wp_version`.
	include ABSPATH . WPINC . '/version.php'; /* @phpstan-ignore-line */

	if ( ! isset( $wp_version ) ) {
		return get_bloginfo( 'version' ); // Fallback.
	}

	// Strip '-src' from the version string. Messes up version_compare().
	return str_replace( '-src', '', $wp_version );
}

require_once plugin_dir_path( __FILE__ ) . 'db.php';
require_once plugin_dir_path( __FILE__ ) . 'capabilities.php';
require_once plugin_dir_path( __FILE__ ) . 'ui.php';
