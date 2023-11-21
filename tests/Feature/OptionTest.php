<?php

namespace Arandu\LaravelSiteOptions\Tests\Feature;

use Arandu\LaravelSiteOptions\Option;
use Arandu\LaravelSiteOptions\Tests\TestCase;

class OptionTest extends TestCase
{
    /** @test */
    public function checkOptionInsertionAndRetrieval()
    {
        Option::set('name', 'value');

        $this->assertEquals('value', Option::get('name'));
    }

    /** @test */
    public function checkOptionUpdate()
    {
        Option::set('name', 'value');

        Option::set('name', 'new value');

        $this->assertEquals('new value', Option::get('name'));
    }

    /** @test */
    public function checkOptionHas()
    {
        Option::set('name', 'value');

        $this->assertTrue(Option::has('name'));
    }

    /** @test */
    public function checkOptionDeletion()
    {
        Option::set('name', 'value');

        Option::rm('name');

        $this->assertFalse(Option::has('name'));
    }

    /** @test */
    public function checkOptionRetrievalWithDefault()
    {
        $this->assertEquals('default', Option::get('name', 'default'));
    }

    /** @test */
    public function checkArrayOption()
    {
        Option::set('name', ['foo' => 'bar']);

        $this->assertEquals(['foo' => 'bar'], Option::get('name'));
    }
    


}
