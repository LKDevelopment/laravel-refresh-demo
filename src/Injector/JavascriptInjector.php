<?php
/**
 * Created by PhpStorm.
 * User: lukaskammerling
 * Date: 15.02.17
 * Time: 22:13
 */

namespace LKDevelopment\LaravelDemoRefresh\Injector;


class JavascriptInjector extends BaseInjector
{

    /**
     * @return string
     */
    public function inject()
    {
        $pos = strripos($this->baseHtmlString, '</body>');
        if (false !== $pos) {
            $content = substr($this->baseHtmlString, 0, $pos) . $this->renderInjectableContent() . substr($this->baseHtmlString, $pos);
        } else {
            $content = $this->baseHtmlString . $this->renderInjectableContent();
        }
        return $content;
    }

    /**
     * @return string
     */
    protected function renderInjectableContent()
    {
        return view('demo-refresh::baseView');
    }
}