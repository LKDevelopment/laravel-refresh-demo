<?php
/**
 * Created by PhpStorm.
 * User: lukaskammerling
 * Date: 16.02.17
 * Time: 14:57
 */

namespace LKDevelopment\LaravelRefreshDemo\Facade;


use Illuminate\Support\Facades\Facade;

class RefreshDemo extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    protected static function getFacadeAccessor()
    {
        return 'refresh-demo';
    }

}