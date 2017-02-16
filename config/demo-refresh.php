<?php
return [
    'enabled' => true,
    'refreshAll' => 60 * 10, // Minutes
    'refresher' => \LKDevelopment\LaravelDemoRefresh\Refresher\DBSeedRefresher::class,
    'dateTimeFormat' => 'H:i',
    'DBSeedRefresher' => [
        'tables' => [
            'users'
        ],
        'seeder' => [
            UserTestSeeder::class
        ]
    ]
];