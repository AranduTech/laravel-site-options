# Laravel Site Options

[![Tests](https://github.com/AranduTech/laravel-site-options/actions/workflows/tests.yml/badge.svg)](https://github.com/AranduTech/laravel-site-options/actions/workflows/tests.yml)

Laravel Site Options is a lightweight package designed for Laravel applications to manage global site settings seamlessly. It provides a straightforward interface for storing and retrieving dictionary-oriented options from the database, with built-in caching capabilities for enhanced performance.

## Installation

Install the package via composer:

```bash
composer require arandu/laravel-site-options
```

Publish the configuration and migration files:

```bash
php artisan vendor:publish --provider="Arandu\LaravelSiteOptions\SiteOptionsServiceProvider"
```

Execute the migration to set up the database table:

```bash
php artisan migrate
```

## Basic Usage

The package provides a fluent, expressive API for managing site options:

``` php
use Arandu\LaravelSiteOptions\Option;

// Storing options
Option::set('welcome_message', 'Hello, World!');
Option::set('site_settings', ['theme' => 'dark', 'layout' => 'wide']);

// Retrieving options
echo Option::get('welcome_message');
$settings = Option::get('site_settings', $fallbackSettings);

// Checking existence
if (Option::has('maintenance_mode')) {
    // Perform action
}

// Removing options
Option::rm('outdated_option');
```

## Application Examples

 - **Feature Toggles**: Manage feature flags for enabling or disabling application features dynamically.
 - **Site Settings**: Store and retrieve global site settings like site name, logo, etc.
 - **Configurable Content**: Store and retrieve content that can be configured by some administrator user, like the phone number on the footer, or how much time to wait before showing a popup.
 - And whatever else you can think of!

## Configuration

Configure the package in `config/site-options.php`:

 - `table`: Name of the database table for storing options.
 - `cache`: Caching settings.
   - `enabled`: Toggle caching (true/false). Settable in `.env` as `SITE_OPTIONS_CACHE_ENABLED`.
   - `key`: Cache key for storing options.
   - `ttl`: Cache TTL in minutes. Settable in `.env` as `SITE_OPTIONS_CACHE_TTL`.
 - `hard_defaults`: Hard-coded default values for options, overridable in `Option::get()`.

To adjust these settings, edit the `config/site-options.php` file. For environment-specific settings, use the `.env` file.

## Issues

If you discover any issues, please use the [GitHub issue tracker](https://github.com/AranduTech/laravel-site-options/issues).

## Security

Please refer to [SECURITY.md](SECURITY.md) for more information.

## Contributing

Contributions are welcome! Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details.


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

