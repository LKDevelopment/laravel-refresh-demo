<?php

namespace LKDevelopment\LaravelRefreshDemo\Refresher;


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RefreshWithSeeds extends BaseRefresher
{

    /**
     * @return void
     */
    public function refreshData()
    {
        $this->truncateTables();
        foreach (config('refresh-demo.RefreshWithSeedsConfiguration.seeder') as $seeder) {
            Artisan::call('db:seed',['--class' => $seeder]);
        }
    }

    protected function truncateTables()
    {
        foreach (config('refresh-demo.RefreshWithSeedsConfiguration.tables') as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
            }
        }
    }
}