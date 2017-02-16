<?php
/**
 * Created by PhpStorm.
 * User: lukaskammerling
 * Date: 15.02.17
 * Time: 21:48
 */

namespace LKDevelopment\LaravelDemoRefresh\Middleware;

use Error;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Debug\ExceptionHandler;
use LKDevelopment\LaravelDemoRefresh\DemoRefresh;
use Symfony\Component\Debug\Exception\FatalThrowableError;

/**
 * Class DemoRefreshMiddleware
 * (Based on https://github.com/barryvdh/laravel-debugbar/blob/master/src/Middleware/Debugbar.php)
 * @package LKDevelopment\LaravelDemoRefresh\Middleware
 */
class DemoRefreshMiddleware
{
    /**
     * @var Container
     */
    protected $container;
    /**
     * @var DemoRefresh
     */
    protected $demoRefresh;

    /**
     * DemoRefreshMiddleware constructor.
     * @param Container $container
     * @param DemoRefresh $demoRefresh
     */
    public function __construct(Container $container, DemoRefresh $demoRefresh)
    {
        $this->container = $container;
        $this->demoRefresh = $demoRefresh;
    }


    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            /** @var \Illuminate\Http\Response $response */
            $response = $next($request);
        } catch (Exception $e) {
            $response = $this->handleException($request, $e);
        } catch (Error $error) {
            $e = new FatalThrowableError($error);
            $response = $this->handleException($request, $e);
        }
        if (config('demo-refresh.enabled') === true) {
            // Modify the response to add the Demo Refresh Popover only if it is enabled
            $this->demoRefresh->modifyResponse($request, $response);
        }
        return $response;

    }

    /**
     * Handle the given exception.
     *
     * (Copy from Illuminate\Routing\Pipeline by Taylor Otwell)
     *
     * @param $passable
     * @param  Exception $e
     * @return mixed
     * @throws Exception
     */
    protected function handleException($passable, Exception $e)
    {
        if (!$this->container->bound(ExceptionHandler::class) || !$passable instanceof Request) {
            throw $e;
        }
        $handler = $this->container->make(ExceptionHandler::class);
        $handler->report($e);
        return $handler->render($passable, $e);
    }
}