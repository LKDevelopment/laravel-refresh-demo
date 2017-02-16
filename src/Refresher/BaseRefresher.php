<?php
/**
 * Created by PhpStorm.
 * User: lukaskammerling
 * Date: 15.02.17
 * Time: 22:18
 */

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