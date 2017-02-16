<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\LKDevelopment\LaravelRefreshDemo\Tests\TestApp\Models\TestUser::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
