<?php

// This is a helper file to add some missing methods that 
// exists on a Laravel project but not on a standalone package.
// This file should never be included. It is meant to be read
// by your IDE or code analyzer.

if (!function_exists('config')) {
    function config($key, $default = null)
    {
        return $default;
    }
}

if (!function_exists('database_path')) {
    function database_path($path = '')
    {
        return $path;
    }
}

if (!function_exists('resource_path')) {
    function resource_path($path = '')
    {
        return $path;
    }
}

if (!function_exists('config_path')) {
    function config_path($path = '')
    {
        return $path;
    }
}

