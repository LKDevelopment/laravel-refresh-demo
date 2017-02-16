<?php

namespace LKDevelopment\LaravelRefreshDemo\Refresher;

/**
 * Class BaseRefresher
 * @package LKDevelopment\LaravelRefreshDemo\Refresher
 */
abstract class BaseRefresher
{
    /**
     * @return void
     */
    public abstract function refreshData();
}