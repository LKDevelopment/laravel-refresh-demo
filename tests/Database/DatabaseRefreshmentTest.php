<?php
/**
 * Created by PhpStorm.
 * User: lukaskammerling
 * Date: 16.02.17
 * Time: 19:29
 */

namespace LKDevelopment\LaravelRefreshDemo\Tests\Database;

use LKDevelopment\LaravelRefreshDemo\Tests\TestApp\Models\TestUser;
use LKDevelopment\LaravelRefreshDemo\Tests\TestCase;

class DatabaseRefreshmentTest extends TestCase
{

    public function test_database_refreshment()
    {
        $user_start = factory(TestUser::class)->create([ 'name' => 'Test1' ]);

        $user_test = TestUser::find($user_start->id);
        $this->assertEquals($user_start, $user_test);
    }
}