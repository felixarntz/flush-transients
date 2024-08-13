=== Flush Transients ===

Plugin Name:       Flush Transients
Plugin URI:        https://wordpress.org/plugins/flush-transients/
Author:            Felix Arntz
Author URI:        https://felix-arntz.me
Contributors:      flixos90
Donate link:       https://felix-arntz.me/wordpress-plugins/
Requires at least: 5.0
Tested up to:      6.6
Requires PHP:      5.2
Stable tag:        1.0.0
License:           GPLv2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html
Tags:              transients, cache, flushing, invalidation, performance

This plugin allows you to flush WordPress transients, plain and simple.

== Description ==

Just like many other plugins offer a feature to flush the WordPress object cache, this plugin allows to flush transients.

Many WordPress sites do not have access to an object cache in their hosting environment, and for those sites transients are the only mechanism for caching data which WordPress natively supports. Being able to clear transients can be crucial for certain use-cases, particularly on sites that do not use an object cache.

This plugin adds a small admin bar menu item where users with the required capabilities can flush transients for the site. For sites not using an object cache, where transients are stored in the database, the menu item also provides information on the amount of transients stored.

Both regular transients and network transients are supported. When using WordPress Multisite, network transients can be flushed in the Network Admin UI.

== Installation ==

1. Upload the entire `flush-transients` folder to the `/wp-content/plugins/` directory or download it through the WordPress backend.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= Which users can flush transients? =

The plugin checks for a new capability `flush_transients`. By default, it is granted to any user that has the `manage_options` capability.

To disable this default behavior, you can unhook the relevant function:

`
<?php
remove_filter( 'user_has_cap', 'flush_transients_grant_cap' );
`

Note however that in this case you will have to grant the capability in another way outside of this plugin.

When using WordPress Multisite, network transients can only be flushed by network administrators by default, relying on a distinct `flush_network_transients` capability.

= Where can I configure the plugin? =

This plugin doesn't come with a settings screen or options of any kind. You can flush transients via the admin bar menu item.

= Where should I submit my support request? =

For regular support requests, please use the [wordpress.org support forums](https://wordpress.org/support/plugin/flush-transients). If you have a technical issue with the plugin where you already have more insight on how to fix it, you can also [open an issue on GitHub instead](https://github.com/felixarntz/flush-transients/issues).

= How can I contribute to the plugin? =

If you have ideas to improve the plugin or to solve a bug, feel free to raise an issue or submit a pull request in the [GitHub repository for the plugin](https://github.com/felixarntz/flush-transients). Please stick to the [contributing guidelines](https://github.com/felixarntz/flush-transients/blob/main/CONTRIBUTING.md).

You can also contribute to the plugin by translating it. Simply visit [translate.wordpress.org](https://translate.wordpress.org/projects/wp-plugins/flush-transients) to get started.

== Screenshots ==

1. The admin bar entry to flush transients

== Changelog ==

= 1.0.0 =
* First stable release

= 1.0.0-beta.1 =
* First beta release
