<?php
/**
 * Created by PhpStorm.
 * User: lukaskammerling
 * Date: 16.02.17
 * Time: 19:18
 */

namespace LKDevelopment\LaravelRefreshDemo\Tests;

use LKDevelopment\LaravelRefreshDemo\LaravelRefreshDemoServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

/**
 * Class TestCase
 * @package LKDevelopment\LaravelRefreshDemo\Tests
 */
abstract class TestCase extends Orchestra
{

    /**
     * @return \Illuminate\Foundation\Application
     */
    protected function getApp()
    {
        return $this->app;
    }


    /**
     *
     */
    public function setUp()
    {
        parent::setUp();
        $this->withFactories(__DIR__.'/TestApp/Factories');
    }


    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('mail.driver', 'log');
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'prefix'   => '',
            'database' => ':memory:',
        ]);
        $this->setUpDatabase();
    }

    /**
     *
     */
    protected function setUpDatabase()
    {
        include_once __DIR__.'/TestApp/Migrations/2014_10_12_000000_create_users_table_for_tests.php';
        (new \CreateUsersTableForTests())->up();
    }


    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            LaravelRefreshDemoServiceProvider::class,
        ];
    }
}