<?php

return [
    /*
     * Switch this boolean to en-/disable the Refresh Demo Package
     */
    'enabled' => true,
    /*
     * Define in which interval the Demo Refresh should performed
     */
    'refreshAllMinutes' => 60 * 1, // Minutes
    /*
     * Define the Refresher you want to use
     */
    'refresher' => \LKDevelopment\LaravelRefreshDemo\Refresher\RefreshWithSeeds::class,
    'views'     => [
        /*
         * Use your App Font Awesome 4? If this is true a Spinner is displayed in the Popup
         */
        'fontAwesome4' => true,
        /*
         * How much seconds should the user wait before he can access the page
         */
        'holdUserOnPopupForSeconds' => 10,
    ],
    /*
     * Configuration for the Out of the Box Refresh with Laravel Seed Configuration
     */
    'RefreshWithSeedsConfiguration' => [
        /*
         * Determinate which database tables should be truncated in the refreshment
         */
        'tables' => [
            'users',
        ],
        /*
         * Determinate the Seeders that should be run in the refreshment
         */
        'seeder' => [
            UserTestSeeder::class,
        ],
    ],
];
