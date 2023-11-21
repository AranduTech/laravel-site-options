<?php

namespace Arandu\LaravelSiteOptions\Tests\Feature;

class OptionWithoutCacheTest extends OptionTest
{
    
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        $app['config']->set('site-options.cache.enabled', false);
    }

}