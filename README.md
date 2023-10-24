# Laravel Site Options

Easy interface for storing site options on database.

## Installation

You can install the package via composer:

```bash
composer require arandu/laravel-site-options
```

Publish config and migration files:

```bash
php artisan vendor:publish --provider="Arandu\LaravelSiteOptions\SiteOptionsServiceProvider"
```

## Usage

``` php
use Arandu\LaravelSiteOptions\Models\Option;

// Set option
Option::set('option_name', 'option_value');
Option::set('option_name', ['arrays' => 'are valid']);

// Get option
Option::get('option_name');
Option::get('option_name', 'default_value');

// Check if option exists
Option::has('option_name');

// Delete option
Option::rm('option_name');
```
