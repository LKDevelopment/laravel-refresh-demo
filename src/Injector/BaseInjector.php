<?php
/**
 * Created by PhpStorm.
 * User: lukaskammerling
 * Date: 15.02.17
 * Time: 22:07
 */

namespace LKDevelopment\LaravelRefreshDemo\Injector;


/**
 * Class BaseInjector
 * @package LKDevelopment\LaravelRefreshDemo\Middleware\Injector
 */
abstract class BaseInjector
{
    /**
     * @var string
     */
    protected $baseHtmlString;

    /**
     * BaseInjector constructor.
     * @param $baseHtmlString
     */
    public function __construct($baseHtmlString)
    {
        $this->baseHtmlString = $baseHtmlString;
    }

    /**
     * @return string
     */
    public abstract function inject();

    /**
     * @return string
     */
    protected abstract function renderInjectableContent();
}