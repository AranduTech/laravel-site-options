<?php

return [
    // The database table where site options are stored.
    'table' => 'site_options',

    // Cache configuration for site options.
    'cache' => [
        // Whether caching is enabled for site options.
        'enabled' => env('SITE_OPTIONS_CACHE_ENABLED', true),

        // The cache key used to store site options.
        // Change this if you have a naming conflict with another cache key.
        'key' => 'site_options',

        // Time-to-live for cached site options, in minutes.
        // Default is set for one week (7 days).
        // This duration is chosen to balance performance and freshness of data.
        'ttl' => env('SITE_OPTIONS_CACHE_TTL', 60 * 24 * 7), // fallback to 7 days
    ],

    // Hardcoded default values for site options.
    // These are used when options are not present in the database.
    // Defaults can be overridden when calling `Option::get()`.
    'hard_defaults' => [
        // Example: 'option_name' => 'option_value',
    ],
];
