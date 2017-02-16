<?php
/**
 * Created by PhpStorm.
 * User: lukaskammerling
 * Date: 15.02.17
 * Time: 21:35
 */

namespace LKDevelopment\LaravelDemoRefresh;


use Illuminate\Support\ServiceProvider;
use LKDevelopment\LaravelDemoRefresh\Middleware\DemoRefreshMiddleware;

/**
 * Class LaravelDemoRefreshServiceProvider
 * @package LKDevelopment\LaravelDemoRefresh
 */
class LaravelDemoRefreshServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'demo-refresh');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'demo-refresh');

        $this->publishes([
            __DIR__ . '/../config/demo-refresh.php' => config_path('demo-refresh.php'),
        ], 'config');
        $this->publishes([
            __DIR__ . '/../resources/views' => base_path('resources/views/vendor/demo-refresh'),
        ], 'views');
        $this->publishes([
            __DIR__ . '/../resources/lang' => base_path('resources/lang/vendor/demo-refresh'),
        ], 'lang');
    }

    /**
     *
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/demo-refresh.php', 'demo-refresh'
        );
        $this->app->singleton('demo-refresh', function ($app) {
            return new DemoRefresh($app);
        });

        $demoRefresh = $this->app['demo-refresh'];
        /**
         * @var $demoRefresh DemoRefresh
         */
        $demoRefresh->boot();

        $this->registerMiddleware(DemoRefreshMiddleware::class);
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