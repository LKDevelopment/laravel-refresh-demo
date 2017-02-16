<?php
/**
 * Created by PhpStorm.
 * User: lukaskammerling
 * Date: 15.02.17
 * Time: 22:20
 */

namespace LKDevelopment\LaravelRefreshDemo\Refresher;


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DBSeedRefresher extends BaseRefresher
{

    /**
     * @return void
     */
    public function refreshData()
    {
        $this->truncateTables();
        foreach (config('refresh-demo.DBSeedRefresher.seeder') as $seeder) {
            Artisan::call('db:seed',['--class' => $seeder]);
        }
    }

    protected function truncateTables()
    {
        foreach (config('refresh-demo.DBSeedRefresher.tables') as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
            }
        }
    }
}