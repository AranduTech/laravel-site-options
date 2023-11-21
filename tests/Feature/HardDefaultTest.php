<?php

namespace Arandu\LaravelSiteOptions\Tests\Feature;

use Arandu\LaravelSiteOptions\Option;
use Arandu\LaravelSiteOptions\Tests\TestCase;

class HardDefaultTest extends TestCase
{

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $i = 1;
        foreach ($this->samples as $serialized => $value) {
            $app['config']->set('site-options.hard_defaults.option_'.$i, $value);
            $i++;
        }
    }

    /** @test */
    public function verifyOptionGetWithHardDefault()
    {
        $i = 1;
        foreach ($this->samples as $unserialized) {
            $key = 'option_' . $i;
            $this->assertEquals($unserialized, Option::get($key));
            $i++;
        }
    }

    /** @test */
    public function verifyOptionGetDefaultPrecedence()
    {
        $i = 1;
        foreach ($this->samples as $unserialized) {
            $key = 'option_' . $i;
            $this->assertEquals('foo', Option::get($key, 'foo'));
            $i++;
        }
    }

    /** @test */
    public function verifySettedValuePrecedence()
    {
        $i = 1;
        foreach ($this->samples as $unserialized) {
            $key = 'option_' . $i;
            Option::set($key, 'foo');
            $this->assertEquals('foo', Option::get($key));
            $i++;
        }
    }

}