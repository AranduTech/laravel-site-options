<?php

namespace Arandu\LaravelSiteOptions\Tests\Feature;

use Arandu\LaravelSiteOptions\Option;
use Arandu\LaravelSiteOptions\Tests\TestCase;

class OptionWithHardDefaultTest extends OptionTest
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

}