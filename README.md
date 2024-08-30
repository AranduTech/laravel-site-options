# Laravel Site Options

[![Tests](https://github.com/AranduTech/laravel-site-options/actions/workflows/tests.yml/badge.svg)](https://github.com/AranduTech/laravel-site-options/actions/workflows/tests.yml)

Laravel Site Options is a powerful yet easy-to-use package tailored for Laravel developers who need to manage global site settings effortlessly. Whether you're building a dynamic web application or a complex platform, this package provides a clean, intuitive interface to store and retrieve site-wide options with built-in caching for superior performance.

## 🚀 Installation

Getting started is simple. Install the package via Composer:

```bash
composer require arandu/laravel-site-options
```

Next, publish the configuration and migration files:

```bash
php artisan vendor:publish --provider="Arandu\LaravelSiteOptions\SiteOptionsServiceProvider"
```

Run the migration to create the necessary database table:

```bash
php artisan migrate
```

## 💡 Usage

Laravel Site Options offers a fluent API that makes managing site options a breeze:

``` php
use Arandu\LaravelSiteOptions\Option;

// Store options
Option::set('welcome_message', 'Hello, World!');
Option::set('site_settings', ['theme' => 'dark', 'layout' => 'wide']);

// Retrieve options
echo Option::get('welcome_message');

$settings = Option::get('site_settings', [
    // ... the default settings
]);

// Check if an option exists
if (Option::has('maintenance_mode')) {
    // Perform action
}

// Remove options
Option::rm('outdated_option');
```

For more details, check out the [advanced usage section](.docs/advanced.md).

## 🌟 Features

- **Feature Toggles**: Easily manage feature flags for enabling or disabling features on the fly.
- **Global Site Settings**: Store and retrieve essential site settings like site name, logo, and more.
- **Dynamic Content**: Allow administrators to configure content such as footer phone numbers or popup delay times.
- **And more**: The possibilities are endless!

## ⚙️ Configuration

Customize the package settings in `config/site-options.php`:

- **`table`**: Define the database table name for storing options.
- **`cache`**: Fine-tune caching settings.
  - **`enabled`**: Toggle caching (true/false), configurable via `.env` as `SITE_OPTIONS_CACHE_ENABLED`.
  - **`key`**: Set the cache key for storing options.
  - **`ttl`**: Define cache TTL in minutes, configurable via `.env` as `SITE_OPTIONS_CACHE_TTL`.
- **`hard_defaults`**: Specify hard-coded default values for options. If you specify a default value when calling `Option::get()`, that value will take precedence.

Modify `config/site-options.php` to fit your needs, and for environment-specific configurations, use the `.env` file.

## 🔄 Version Compatibility

Refer to the table below to match your Laravel version with the appropriate Laravel Site Options version:

| Laravel Framework | Laravel Site Options |
| ----------------- | -------------------- |
| 8.x               | 1.x                  |
| 9.x               | 2.x                  |
| 10.x              | 3.x                  |
| 11.x              | 4.x                  |

## 🛠️ Testing

``` bash
composer test
```

## 🚨 Issues

Encounter a problem? Report it on our [GitHub issue tracker](https://github.com/AranduTech/laravel-site-options/issues).

## 🔒 Security

For security-related concerns, please refer to [SECURITY.md](SECURITY.md).

## 🤝 Contributing

We welcome contributions from the community! Please read [CONTRIBUTING.md](CONTRIBUTING.md) to get started.

## 📜 License

This project is open-sourced under the MIT License. See the [LICENSE](LICENSE.md) file for more details.
