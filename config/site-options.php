<?php

return [
    'table' => 'site_options',
    'cache' => [
        'enabled' => true,
        'key' => 'site_options',
        'ttl' => 60 * 24 * 7, // 7 days
    ],
];