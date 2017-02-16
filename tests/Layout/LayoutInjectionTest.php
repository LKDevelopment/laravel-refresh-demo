<?php
/**
 * Created by PhpStorm.
 * User: lukaskammerling
 * Date: 16.02.17
 * Time: 22:24.
 */

namespace LKDevelopment\LaravelRefreshDemo\Tests\Layout;

use LKDevelopment\LaravelRefreshDemo\Tests\TestCase;
use LKDevelopment\LaravelRefreshDemo\Refresher\RefreshWithSeeds;
use LKDevelopment\LaravelRefreshDemo\Tests\TestApp\Seeder\UserTestSeeder;

/**
 * Class LayoutTest.
 */
class LayoutInjectionTest extends TestCase
{
    /**
     * @return mixed
     */
    protected function setUpRefreshWithSeeder()
    {
        $this->getApp()['config']->set('app.locale', 'en');
        $this->getApp()['config']->set('refresh-demo.refreshAllMinutes', 0);
        $this->getApp()['config']->set('refresh-demo.refresher', RefreshWithSeeds::class);
        $this->getApp()['config']->set('refresh-demo.RefreshWithSeedsConfiguration.tables', ['test_users']);
        $this->getApp()['config']->set('refresh-demo.RefreshWithSeedsConfiguration.seeder', [UserTestSeeder::class]);
    }

    public function test_injected_response()
    {
        $this->setUpRefreshWithSeeder();
        $response = \Response::make('<body>TEST</body>');
        \RefreshDemo::modifyResponse($this->getApp()['request'], $response);
        $this->assertContains('<h2>'.trans('refresh-demo::refresh-demo.refreshModal.header').'</h2>',
            $response->content());
    }
}
