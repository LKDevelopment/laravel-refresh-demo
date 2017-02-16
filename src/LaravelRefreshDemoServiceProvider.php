<?php

namespace LKDevelopment\LaravelRefreshDemo;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use LKDevelopment\LaravelRefreshDemo\Middleware\RefreshDemoMiddleware;
use LKDevelopment\LaravelRefreshDemo\Facade\RefreshDemo as RefreshDemoFacade;

/**
 * Class LaravelRefreshDemoServiceProvider.
 */
class LaravelRefreshDemoServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'refresh-demo');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'refresh-demo');

        $this->publishes([
            __DIR__.'/../config/refresh-demo.php' => config_path('refresh-demo.php'),
        ], 'config');
        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/refresh-demo'),
        ], 'views');
        $this->publishes([
            __DIR__.'/../resources/lang' => base_path('resources/lang/vendor/refresh-demo'),
        ], 'lang');
        $demoRefresh = $this->app['refresh-demo'];
        /*
         * @var $demoRefresh RefreshDemo
         */
        $demoRefresh->boot();
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/refresh-demo.php', 'refresh-demo'
        );
        $this->app->singleton('refresh-demo', function ($app) {
            return new RefreshDemo($app);
        });
        /**
         * Load Facade.
         */
        $loader = AliasLoader::getInstance();
        $loader->alias('RefreshDemo', RefreshDemoFacade::class);

        $this->registerMiddleware(RefreshDemoMiddleware::class);
    }

    /**
     * @param $middleware
     * (Copied from Barry vd. Heuvel Debugbar Service Provider)
     */
    protected function registerMiddleware($middleware)
    {
        $kernel = $this->app['Illuminate\Contracts\Http\Kernel'];
        $kernel->pushMiddleware($middleware);
    }
}
