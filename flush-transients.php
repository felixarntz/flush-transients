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
 * Version: 1.0.0
 * Requires at least: 5.0
 * Requires PHP: 5.2
 * Author: Felix Arntz
 * Author URI: https://felix-arntz.me
 * License: GNU General Public License v2 (or later)
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: flush-transients
 * Tags: transients, cache, flushing, invalidation, clearing, performance, user experience, lightweight
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once plugin_dir_path( __FILE__ ) . 'db.php';
require_once plugin_dir_path( __FILE__ ) . 'capabilities.php';
require_once plugin_dir_path( __FILE__ ) . 'ui.php';
