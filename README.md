# Laravel Site Options

Extra small package for storing global site options on database, with caching support.

## Installation

You can install the package via composer:

```bash
composer require arandu/laravel-site-options
```

Publish config and migration files:

```bash
php artisan vendor:publish --provider="Arandu\LaravelSiteOptions\SiteOptionsServiceProvider"
```

Run the migration:

```bash
php artisan migrate
```

## Usage

``` php
use Arandu\LaravelSiteOptions\Option;

// Set option
Option::set('option_name', 'option value');
Option::set('option_name', ['arrays' => 'are valid']);

// Get option
Option::get('option_name');
Option::get('option_name', 'default_value');

// Check if option exists
Option::has('option_name');

// Delete option
Option::rm('option_name');
```

## Site Options Configuration

The `config/site-options.php` file is responsible for defining configurations related to site options in the application. This includes settings for the database table, caching, and default values.

### Configuration Details

- `table`: Specifies the database table name where site options are stored.
- `cache`: Contains settings for caching site options.
  - `enabled`: Boolean value to enable or disable cache.
  - `key`: The cache key under which site options are stored.
  - `ttl`: Time-to-live for the cache, in minutes. Can be set via the `.env` file using `SITE_OPTIONS_CACHE_TTL`.
- `hard_defaults`: Provides a way to set default values for options not present in the database. These can be overridden when using `Option::get()`.

### Editing Configuration

To modify these configurations, edit the `config/site-options.php` file directly. For environment-specific settings like cache TTL, use the `.env` file to provide different values for different deployment environments.
