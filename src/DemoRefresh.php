<?php
/**
 * Created by PhpStorm.
 * User: lukaskammerling
 * Date: 15.02.17
 * Time: 21:36
 */

namespace LKDevelopment\LaravelDemoRefresh;


use Carbon\Carbon;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use LKDevelopment\LaravelDemoRefresh\Injector\JavascriptInjector;
use LKDevelopment\LaravelDemoRefresh\Refresher\BaseRefresher;

/**
 * Class DemoRefresh
 * @package LKDevelopment\LaravelDemoRefresh
 */
class DemoRefresh
{
    /**
     *
     */
    const TIME_STORAGE_FILE_NAME = 'demo_refresh';
    /**
     * @var Application
     */
    protected $app;

    /**
     * DemoRefresh constructor.
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->app = $application;
    }

    /**
     *
     */
    public function boot()
    {

    }

    /**
     * @return bool
     */
    protected function checkIfNeedRefresh()
    {
        $path = storage_path('app/' . self::TIME_STORAGE_FILE_NAME);
        if (file_exists($path)) {
            $timestampFromFile = file_get_contents($path);
            $timeFromFile = Carbon::createFromTimestamp($timestampFromFile);
            if ($timeFromFile->addSeconds(config('demo-refresh.refreshAll')) > Carbon::now()) {
                return false;
            }
        }
        return true;
    }

    /**
     * @return void
     */
    protected function placeRefreshTimestampFile()
    {
        $path = storage_path('app/' . self::TIME_STORAGE_FILE_NAME);
        if (file_exists($path)) {
            unlink($path);
        }
        $handle = fopen($path, 'w+');
        fwrite($handle, Carbon::now()->timestamp);
        fclose($handle);
    }

    public function modifyResponse(Request $request, Response $response)
    {
        if (config('demo-refresh.enabled') === true) {
            if ($this->checkIfNeedRefresh() === true) {
                $refresherClassName = config('demo-refresh.refresher');
                $refresher = new $refresherClassName();
                /**
                 * @var BaseRefresher $refresher
                 */
                $refresher->refreshData();
                $this->placeRefreshTimestampFile();
            }

            if ($this->app->runningInConsole() || $this->app->runningUnitTests()) {
                return $response;
            }
            $this->injectDemoRefreshPopUp($response);
        }
        return $response;
    }

    /**
     * @param Response $response
     */
    protected function injectDemoRefreshPopUp(Response $response)
    {
        $content = $response->getContent();
        /**
         * Inject Layout to Response
         */
        $content = with(new JavascriptInjector($content))->inject();

        /**
         * Copied from Barry vd. Heuvel
         */
        $response->setContent($content);
        $response->headers->remove('Content-Length');
    }

    /**
     * @return Carbon
     */
    public static function getNextRollback()
    {
        $path = storage_path('app/' . self::TIME_STORAGE_FILE_NAME);

        if (file_exists($path)) {
            $carbon = with(Carbon::createFromTimestamp(file_get_contents($path)))->addSeconds(config('demo-refresh.refreshAll'));
        } else {
            $carbon = Carbon::now()->addSeconds(config('demo-refresh.refreshAll'));
        }
        return $carbon;
    }
}