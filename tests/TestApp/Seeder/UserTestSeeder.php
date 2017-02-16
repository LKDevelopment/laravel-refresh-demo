<?php

namespace LKDevelopment\LaravelRefreshDemo\Tests\TestApp\Seeder;

use Illuminate\Database\Seeder;
use LKDevelopment\LaravelRefreshDemo\Tests\TestApp\Models\TestUser;

class UserTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 6; $i++) {
            factory(TestUser::class)->create(['name' => 'Seeded User '.$i]);
        }
    }
}
