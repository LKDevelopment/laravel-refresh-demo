<?php

namespace LKDevelopment\LaravelRefreshDemo\Middleware;

use Error;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Debug\ExceptionHandler;
use LKDevelopment\LaravelRefreshDemo\RefreshDemo;
use Symfony\Component\Debug\Exception\FatalThrowableError;

/**
 * Class DemoRefreshMiddleware
 * (Based on https://github.com/barryvdh/laravel-debugbar/blob/master/src/Middleware/Debugbar.php).
 */
class RefreshDemoMiddleware
{
    /**
     * @var Container
     */
    protected $container;
    /**
     * @var RefreshDemo
     */
    protected $demoRefresh;

    /**
     * DemoRefreshMiddleware constructor.
     *
     * @param Container   $container
     * @param RefreshDemo $demoRefresh
     */
    public function __construct(Container $container, RefreshDemo $demoRefresh)
    {
        $this->container = $container;
        $this->demoRefresh = $demoRefresh;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
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
        if (config('refresh-demo.enabled') === true) {
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
     * @param Exception $e
     *
     * @throws Exception
     *
     * @return mixed
     */
    protected function handleException($passable, Exception $e)
    {
        if (! $this->container->bound(ExceptionHandler::class) || ! $passable instanceof Request) {
            throw $e;
        }
        $handler = $this->container->make(ExceptionHandler::class);
        $handler->report($e);

        return $handler->render($passable, $e);
    }
}
