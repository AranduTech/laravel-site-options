<?php

namespace Arandu\LaravelSiteOptions\Tests\Feature;

use Arandu\LaravelSiteOptions\Option;
use Arandu\LaravelSiteOptions\Tests\TestCase;
use Illuminate\Support\Facades\Cache;

class TurnOffCacheTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        $app['config']->set('site-options.cache.enabled', false);
    }

    /** @test */
    public function verifyCacheDisabled()
    {
        $i = 1;
        foreach ($this->samples as $serialized => $unserialized) {
            $key = 'option_' . $i;
            Option::set($key, 'foo');
            $cacheKey = config('site-options.cache.key', 'site_options').':'.$key;
            // null is not cacheable
            if (!is_null($unserialized)) {
                // there should be no cache
                $this->assertFalse(Cache::has($cacheKey));
            }
            // make change directly to db
            $this->db->table('site_options')->where('key', $key)->update(['value' => $serialized]);
            // data should be retrieved from db
            $this->assertEquals($unserialized, Option::get($key));
            $i++;
        }
    }
}