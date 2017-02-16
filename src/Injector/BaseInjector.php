<?php

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