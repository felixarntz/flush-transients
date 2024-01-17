[![PHP Unit Testing](https://img.shields.io/github/actions/workflow/status/felixarntz/flush-transients/php-test.yml?style=for-the-badge&label=PHP%20Unit%20Testing)](https://github.com/felixarntz/flush-transients/actions/workflows/php-test.yml)
[![Packagist version](https://img.shields.io/packagist/v/felixarntz/flush-transients?style=for-the-badge)](https://packagist.org/packages/felixarntz/flush-transients)
[![Packagist license](https://img.shields.io/packagist/l/felixarntz/flush-transients?style=for-the-badge)](https://packagist.org/packages/felixarntz/flush-transients)

# Flush Transients

This plugin allows you to flush WordPress transients, plain and simple.

Just like many other plugins offer a feature to flush the WordPress object cache, this plugin allows to flush transients.

Many WordPress sites do not have access to an object cache in their hosting environment, and for those sites transients are the only mechanism for caching data which WordPress natively supports. Being able to clear transients can be crucial for certain use-cases, particularly on sites that do not use an object cache.

This plugin adds a small admin bar menu item where users with the required capabilities can flush transients for the site. For sites not using an object cache, where transients are stored in the database, the menu item also provides information on the amount of transients stored.

Both regular transients and network transients are supported. When using WordPress Multisite, network transients can be flushed in the Network Admin UI.


## Installation and usage

Eventually, once the plugin has been reviewed and approved in the WordPress plugin repository, you will be able to install it from there. Until then, you can download a ZIP from the [GitHub releases page](https://github.com/felixarntz/flush-transients/releases) and upload it to your WordPress site via _Plugins > Add New > Upload Plugin_.

Alternatively, if you use Composer to manage your WordPress site, you can also [install the plugin from Packagist](https://packagist.org/packages/felixarntz/flush-transients):

```
composer require felixarntz/flush-transients:^1.0.0-beta.1
```

## Frequently asked questions

### Which users can flush transients?

The plugin checks for a new capability `flush_transients`. By default, it is granted to any user that has the `manage_options` capability.

To disable this default behavior, you can unhook the relevant function:

```php
<?php
remove_filter( 'user_has_cap', 'flush_transients_grant_cap' );
```

Note however that in this case you will have to grant the capability in another way outside of this plugin.

When using WordPress Multisite, network transients can only be flushed by network administrators by default, relying on a distinct `flush_network_transients` capability.

### Where can I configure the plugin?

This plugin doesn't come with a settings screen or options of any kind. You can flush transients via the admin bar menu item.

## Contributions

If you have ideas to improve the plugin or to solve a bug, feel free to raise an issue or submit a pull request right here on GitHub. Please refer to the [contributing guidelines](https://github.com/felixarntz/flush-transients/blob/main/CONTRIBUTING.md) to learn more and get started.
