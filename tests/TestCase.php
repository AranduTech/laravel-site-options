<?php

namespace Arandu\LaravelSiteOptions\Tests;

// use Illuminate\;

use Arandu\LaravelSiteOptions\SiteOptionsServiceProvider;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Testing\Concerns\TestDatabases;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{

    protected $samples = [
        's:4:"test";' => 'test',
        'i:3;' => 3,
        'd:3.5;' => 3.5,
        'a:1:{s:3:"foo";s:3:"bar";}' => ['foo' => 'bar'],
        'b:1;' => true,
        'b:0;' => false,
        'N;' => null,
    ];

    protected $database;

    protected $db;

    protected function getPackageProviders($app)
    {
        return [SiteOptionsServiceProvider::class];
    }


    protected function setUp(): void
    {
        parent::setUp();

        $this->database = getenv('DATABASE') ?: 'sqlite';

        $config = require __DIR__ . '/config/database.ci.php';

        $db = new DB();
        $db->addConnection($config[$this->database]);
        $db->setAsGlobal();
        $db->bootEloquent();

        $this->db = $db;

        $this->migrate();

    }

    protected function tearDown(): void
    {
        $this->db->getConnection()->disconnect();
        parent::tearDown();
    }

    protected function migrate()
    {

        DB::schema()->dropAllTables();

        DB::schema()->create('site_options', function ($table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->timestamps();

            $table->index('key');
        });

    }
    
}
