[![WordPress plugin version](https://img.shields.io/wordpress/plugin/v/flush-transients?style=for-the-badge)](https://wordpress.org/plugins/flush-transients/)
[![WordPress tested version](https://img.shields.io/wordpress/plugin/tested/flush-transients?style=for-the-badge)](https://wordpress.org/plugins/flush-transients/)
[![WordPress plugin downloads](https://img.shields.io/wordpress/plugin/dt/flush-transients?style=for-the-badge)](https://wordpress.org/plugins/flush-transients/)
[![PHP Unit Testing](https://img.shields.io/github/actions/workflow/status/felixarntz/flush-transients/php-test.yml?style=for-the-badge&label=PHP%20Unit%20Testing)](https://github.com/felixarntz/flush-transients/actions/workflows/php-test.yml)
[![Packagist version](https://img.shields.io/packagist/v/felixarntz/flush-transients?style=for-the-badge)](https://packagist.org/packages/felixarntz/flush-transients)
[![Packagist license](https://img.shields.io/packagist/l/felixarntz/flush-transients?style=for-the-badge)](https://packagist.org/packages/felixarntz/flush-transients)

# Flush Transients

This plugin allows you to flush WordPress transients, plain and simple.

<img width="992" alt="The admin bar entry to flush transients" src="https://github.com/felixarntz/flush-transients/assets/3531426/5ba63b27-3431-4ba2-8776-1ec224007062">

Just like many other plugins offer a feature to flush the WordPress object cache, this plugin allows to flush transients.

Many WordPress sites do not have access to an object cache in their hosting environment, and for those sites transients are the only mechanism for caching data which WordPress natively supports. Being able to clear transients can be crucial for certain use-cases, particularly on sites that do not use an object cache.

This plugin adds a small admin bar menu item where users with the required capabilities can flush transients for the site. For sites not using an object cache, where transients are stored in the database, the menu item also provides information on the amount of transients stored.

Both regular transients and network transients are supported. When using WordPress Multisite, network transients can be flushed in the Network Admin UI.


## Installation and usage

You can download the latest version from the [WordPress plugin repository](https://wordpress.org/plugins/flush-transients/).

Please see the [plugin repository installation instructions](https://wordpress.org/plugins/flush-transients/#installation) for detailed information on installation and the [plugin repository FAQ](https://wordpress.org/plugins/flush-transients/#faq) for additional details on usage and customization.

Alternatively, if you use Composer to manage your WordPress site, you can also [install the plugin from Packagist](https://packagist.org/packages/felixarntz/flush-transients):

```
composer require felixarntz/flush-transients:^1.0
```

## Contributions

If you have ideas to improve the plugin or to solve a bug, feel free to raise an issue or submit a pull request right here on GitHub. Please refer to the [contributing guidelines](https://github.com/felixarntz/flush-transients/blob/main/CONTRIBUTING.md) to learn more and get started.

You can also contribute to the plugin by translating it. Simply visit [translate.wordpress.org](https://translate.wordpress.org/projects/wp-plugins/flush-transients) to get started.
