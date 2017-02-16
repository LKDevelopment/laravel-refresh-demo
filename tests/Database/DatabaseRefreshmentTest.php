<?php
/**
 * Created by PhpStorm.
 * User: lukaskammerling
 * Date: 16.02.17
 * Time: 19:29
 */

namespace LKDevelopment\LaravelRefreshDemo\Tests\Database;

use LKDevelopment\LaravelRefreshDemo\Facade\RefreshDemo;
use LKDevelopment\LaravelRefreshDemo\Refresher\RefreshWithSeeds;
use LKDevelopment\LaravelRefreshDemo\Tests\TestApp\Models\TestUser;
use LKDevelopment\LaravelRefreshDemo\Tests\TestApp\Seeder\UserTestSeeder;
use LKDevelopment\LaravelRefreshDemo\Tests\TestCase;

/**
 * Class DatabaseRefreshmentTest
 * @package LKDevelopment\LaravelRefreshDemo\Tests\Database
 */
class DatabaseRefreshmentTest extends TestCase
{

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();
        $this->setUpPlainUnRefreshed();
    }


    /**
     *
     */
    protected function setUpPlainUnRefreshed()
    {
        \DB::table('test_users')->truncate();
        for ($i = 1; $i < 6; $i++) {
            factory(TestUser::class)->create([ 'name' => 'Test '.$i ]);
        }
    }


    /**
     * @return mixed
     */
    protected function setUpRefreshWithSeeder()
    {
        $this->getApp()['config']->set('refresh-demo.refreshAllMinutes', 0);
        $this->getApp()['config']->set('refresh-demo.refresher', RefreshWithSeeds::class);
        $this->getApp()['config']->set('refresh-demo.RefreshWithSeedsConfiguration.tables', [ 'test_users' ]);
        $this->getApp()['config']->set('refresh-demo.RefreshWithSeedsConfiguration.seeder', [ UserTestSeeder::class ]);
    }


    /**
     * @return mixed
     */
    protected function setUpRefreshDisabled()
    {
        $this->getApp()['config']->set('refresh-demo.enabled', false);
        $this->getApp()['config']->set('refresh-demo.refresher', RefreshWithSeeds::class);
        $this->getApp()['config']->set('refresh-demo.RefreshWithSeedsConfiguration.tables', [ 'test_users' ]);
        $this->getApp()['config']->set('refresh-demo.RefreshWithSeedsConfiguration.seeder', [ UserTestSeeder::class ]);
    }


    /**
     *
     */
    public function test_database_setup()
    {
        $this->assertEquals(5, TestUser::all()->count());
    }


    /**
     *
     */
    public function test_database_refreshment_with_seeder()
    {
        $this->setUpRefreshWithSeeder();

        $this->assertEquals(5, TestUser::all()->count());

        RefreshDemo::modifyResponse($this->getApp()['request'], \Response::make());

        foreach (TestUser::all() as $testUser) {
            $this->assertEquals('Seeded User '.$testUser->id, $testUser->name);
        }
    }


    /**
     *
     */
    public function test_database_do_not_refresh_because_of_disabled(){
        $this->setUpRefreshDisabled();
        RefreshDemo::modifyResponse($this->getApp()['request'], \Response::make());
        foreach (TestUser::all() as $testUser) {
            $this->assertEquals('Test '.$testUser->id, $testUser->name);
        }


    }
}