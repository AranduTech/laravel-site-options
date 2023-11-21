<?php

namespace Arandu\LaravelSiteOptions\Tests\Feature;

class HardDefaultWithoutCacheTest extends HardDefaultTest
{

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        $app['config']->set('site-options.cache.enabled', false);
    }

}