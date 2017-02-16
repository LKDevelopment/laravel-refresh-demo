<?php
/**
 * Created by PhpStorm.
 * User: lukaskammerling
 * Date: 15.02.17
 * Time: 22:18
 */

namespace LKDevelopment\LaravelDemoRefresh\Refresher;


/**
 * Class BaseRefresher
 * @package LKDevelopment\LaravelDemoRefresh\Refresher
 */
abstract class BaseRefresher
{
    /**
     * @return void
     */
    public abstract function refreshData();
}