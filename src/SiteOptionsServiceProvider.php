<?php

namespace Arandu\LaravelSiteOptions;

use Illuminate\Support\ServiceProvider;

class SiteOptionsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/site-options.php' => config_path('site-options.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../database/migrations/create_site_options_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_site_options_table.php'),
        ], 'migrations');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/site-options.php', 'site-options');
    }
}
