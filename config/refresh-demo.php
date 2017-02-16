<?php
return [
    'enabled' => true,
    'refreshAllMinutes' => 60 * 1, // Minutes
    'refresher' => \LKDevelopment\LaravelRefreshDemo\Refresher\DBSeedRefresher::class,
    'views' => [
        'fontAwesome4' => true,
        'dateTimeFormat' => 'H:i',
        'holdUserOnPopupForSeconds' => 10,
    ],
    'DBSeedRefresher' => [
        'tables' => [
            'users'
        ],
        'seeder' => [
            UserTestSeeder::class
        ]
    ]
];