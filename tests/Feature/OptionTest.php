<?php

namespace Arandu\LaravelSiteOptions\Tests\Feature;

use Arandu\LaravelSiteOptions\Option;
use Arandu\LaravelSiteOptions\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

class OptionTest extends TestCase
{

    /** @test */
    public function verifyOptionSet()
    {
        foreach ($this->samples as $serialized => $unserialized) {
            $key = Str::random();
            Option::set($key, $unserialized);
            $data = $this->db->table('site_options')->where('key', $key)->first();
            $this->assertEquals(is_string($unserialized) ? $unserialized : $serialized, $data->value);
        }
    }

    /** @test */
    public function verifyOptionGet()
    {
        foreach ($this->samples as $serialized => $unserialized) {
            $key = Str::random();
            $this->db->table('site_options')->insert(['key' => $key, 'value' => is_string($unserialized) ? $unserialized : $serialized]);
            $this->assertEquals($unserialized, Option::get($key));
        }
    }

    /** @test */
    public function verifyOptionRewrite()
    {
        foreach ($this->samples as $unserialized) {
            $key = Str::random();
            $this->db->table('site_options')->insert(['key' => $key, 'value' => 'foo']);
            Option::set($key, $unserialized);
            $this->assertEquals(Option::get($key), $unserialized);
        }
    }

    /** @test */
    public function verifyOptionGetWithDefault()
    {
        foreach ($this->samples as $unserialized) {
            $key = Str::random();
            $this->assertEquals($unserialized, Option::get($key, $unserialized));
        }
    }

    /** @test */
    public function verifyOptionExists()
    {
        foreach ($this->samples as $serialized => $unserialized) {
            $key = Str::random();
            $this->assertFalse(Option::has($key));
            $this->db->table('site_options')->insert(['key' => $key, 'value' => is_string($unserialized) ? $unserialized : $serialized]);
            $this->assertTrue(Option::has($key));
        }
    }

    /** @test */
    public function verifyOptionDelete()
    {
        foreach ($this->samples as $serialized => $unserialized) {
            $key = Str::random();
            $this->db->table('site_options')->insert(['key' => $key, 'value' => is_string($unserialized) ? $unserialized : $serialized]);
            Option::rm($key);
            $this->assertFalse($this->db->table('site_options')->where('key', $key)->exists());
        }
    }

}
