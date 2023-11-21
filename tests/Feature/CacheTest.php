<?php

namespace Arandu\LaravelSiteOptions\Tests\Feature;

use Arandu\LaravelSiteOptions\Option;
use Arandu\LaravelSiteOptions\Tests\TestCase;
use Illuminate\Support\Facades\Cache;

class CacheTest extends TestCase
{
    /** @test */
    public function verifyCacheSet()
    {
        $i = 1;
        foreach ($this->samples as $serialized => $unserialized) {
            $key = 'option_' . $i;
            Option::set($key, $unserialized);
            $cacheKey = config('site-options.cache.key', 'site_options').':'.$key;
            // null is not cacheable
            if (!is_null($unserialized)) {
                $this->assertTrue(Cache::has($cacheKey));
            }
            $this->assertEquals($unserialized, Cache::get($cacheKey));
            $i++;
        }
    }

    /** @test */
    public function checkIfCacheHasBeenCleared()
    {
        $this->assertFalse(Cache::has(config('site-options.cache.key', 'site_options').':option_1'));
    }

    /** @test */
    public function verifyCacheGet()
    {
        $i = 1;
        foreach ($this->samples as $serialized => $unserialized) {
            $key = 'option_' . $i;
            // item must be in table to be cached
            $this->db->table('site_options')->insert(['key' => $key, 'value' => 'foo']);
            $cacheKey = config('site-options.cache.key', 'site_options').':'.$key;
            // null is not cacheable
            if (!is_null($unserialized)) {
                Cache::put($cacheKey, $unserialized);
                $this->assertEquals($unserialized, Option::get($key));
            }
            $i++;
        }
    }
}
