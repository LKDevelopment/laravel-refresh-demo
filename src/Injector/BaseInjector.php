<?php

namespace LKDevelopment\LaravelRefreshDemo\Injector;

/**
 * Class BaseInjector.
 */
abstract class BaseInjector
{
    /**
     * @var string
     */
    protected $baseHtmlString;

    /**
     * BaseInjector constructor.
     *
     * @param $baseHtmlString
     */
    public function __construct($baseHtmlString)
    {
        $this->baseHtmlString = $baseHtmlString;
    }

    /**
     * @return string
     */
    abstract public function inject();

    /**
     * @return string
     */
    abstract protected function renderInjectableContent();
}
