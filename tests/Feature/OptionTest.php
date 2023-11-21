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
        $i = 1;
        foreach ($this->samples as $serialized => $unserialized) {
            $key = 'option_' . $i;
            Option::set($key, $unserialized);
            $data = $this->db->table('site_options')->where('key', $key)->first();
            $this->assertEquals(is_string($unserialized) ? $unserialized : $serialized, $data->value);
            $i++;
        }
    }

    /** @test */
    public function verifyOptionGet()
    {
        $i = 1;
        foreach ($this->samples as $serialized => $unserialized) {
            $key = 'option_' . $i;
            $this->db->table('site_options')->insert(['key' => $key, 'value' => is_string($unserialized) ? $unserialized : $serialized]);
            $this->assertEquals($unserialized, Option::get($key));
            $i++;
        }
    }

    /** @test */
    public function verifyOptionRewrite()
    {
        $i = 1;
        foreach ($this->samples as $unserialized) {
            $key = 'option_' . $i;
            $this->db->table('site_options')->insert(['key' => $key, 'value' => 'foo']);
            Option::set($key, $unserialized);
            $this->assertEquals(Option::get($key), $unserialized);
            $i++;
        }
    }

    /** @test */
    public function verifyOptionGetWithDefault()
    {
        $i = 1;
        foreach ($this->samples as $unserialized) {
            $key = 'option_' . $i;
            $this->assertEquals($unserialized, Option::get($key, $unserialized));
            $i++;
        }
    }

    /** @test */
    public function verifyOptionExists()
    {
        $i = 1;
        foreach ($this->samples as $serialized => $unserialized) {
            $key = 'option_' . $i;
            $this->assertFalse(Option::has($key));
            $this->db->table('site_options')->insert(['key' => $key, 'value' => is_string($unserialized) ? $unserialized : $serialized]);
            $this->assertTrue(Option::has($key));
            $i++;
        }
    }

    /** @test */
    public function verifyOptionDelete()
    {
        $i = 1;
        foreach ($this->samples as $serialized => $unserialized) {
            $key = 'option_' . $i;
            $this->db->table('site_options')->insert(['key' => $key, 'value' => is_string($unserialized) ? $unserialized : $serialized]);
            Option::rm($key);
            $this->assertFalse($this->db->table('site_options')->where('key', $key)->exists());
            $i++;
        }
    }

}
