<?php

namespace Arandu\LaravelSiteOptions\Tests\Feature;

use Arandu\LaravelSiteOptions\Tests\TestCase;
use Arandu\LaravelSiteOptions\Support\Serialize;

class SerializationTest extends TestCase
{

    #[\PHPUnit\Framework\Attributes\Test]
    public function encode()
    {
        foreach ($this->samples as $serialized => $unserialized) {
            $this->assertEquals($serialized, Serialize::encode($unserialized));
        }
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function decode()
    {
        foreach ($this->samples as $serialized => $unserialized) {
            $this->assertEquals($unserialized, Serialize::decode($serialized));
        }
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function isEncoded()
    {
        foreach ($this->samples as $serialized => $unserialized) {
            $this->assertTrue(Serialize::isEncoded($serialized));
            $this->assertFalse(Serialize::isEncoded($unserialized));
        }
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function maybeEncode()
    {
        foreach ($this->samples as $serialized => $unserialized) {
            if (is_string($unserialized)) {
                $this->assertEquals($unserialized, Serialize::maybeEncode($unserialized));
                continue;
            }
            $this->assertEquals($serialized, Serialize::maybeEncode($unserialized));
        }
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function maybeDecode()
    {
        foreach ($this->samples as $serialized => $unserialized) {
            if (is_string($unserialized)) {
                $this->assertEquals($unserialized, Serialize::maybeDecode($unserialized));
                continue;
            }
            $this->assertEquals($unserialized, Serialize::maybeDecode($serialized));
        }
    }
   

    
}