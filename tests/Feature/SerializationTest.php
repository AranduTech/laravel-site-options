<?php

namespace Arandu\LaravelSiteOptions\Tests\Feature;

use Arandu\LaravelSiteOptions\Tests\TestCase;
use Arandu\LaravelSiteOptions\Support\Serialize;

class SerializationTest extends TestCase
{

    /** @test */
    public function encode()
    {
        $this->assertEquals('s:4:"test";', Serialize::encode('test'));
    }

    /** @test */
    public function decode()
    {
        $this->assertEquals('test', Serialize::decode('s:4:"test";'));
    }

    /** @test */
    public function isEncoded()
    {
        $this->assertTrue(Serialize::isEncoded('s:4:"test";'));
    }

    /** @test */
    public function isNotEncoded()
    {
        $this->assertFalse(Serialize::isEncoded('test'));
    }

    /** @test */
    public function maybeEncode()
    {
        $this->assertEquals('test', Serialize::maybeEncode('test'));

        $this->assertEquals('i:3;', Serialize::maybeEncode(3));
    }

    /** @test */
    public function maybeDecode()
    {
        $this->assertEquals('test', Serialize::maybeDecode('test'));

        $this->assertEquals(3, Serialize::maybeDecode('i:3;'));
    }
   

    
}