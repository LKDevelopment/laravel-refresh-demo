<?php

use LKDevelopment\LaravelRefreshDemo\Tests\TestApp\Models\TestUser;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(TestUser::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
