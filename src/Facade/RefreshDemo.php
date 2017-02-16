<?php

namespace LKDevelopment\LaravelRefreshDemo\Facade;

use Illuminate\Support\Facades\Facade;

class RefreshDemo extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @throws \RuntimeException
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'refresh-demo';
    }
}
