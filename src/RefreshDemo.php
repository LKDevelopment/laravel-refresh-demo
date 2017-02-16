<?php
/**
 * Created by PhpStorm.
 * User: lukaskammerling
 * Date: 15.02.17
 * Time: 21:36
 */

namespace LKDevelopment\LaravelRefreshDemo;


use Carbon\Carbon;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use LKDevelopment\LaravelRefreshDemo\Injector\JavascriptInjector;
use LKDevelopment\LaravelRefreshDemo\Refresher\BaseRefresher;

/**
 * Class DemoRefresh
 * @package LKDevelopment\LaravelRefreshDemo
 */
class RefreshDemo
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
     * @var boolean
     */
    protected $enabled;

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
        $this->enabled = config('refresh-demo.enabled');
    }

    /**
     * @return void
     */
    protected function performRefreshIfNeeded()
    {
        if ($this->checkIfNeedRefresh() === true) {
            $refresherClassName = config('refresh-demo.refresher');
            $refresher = new $refresherClassName();
            /**
             * @var BaseRefresher $refresher
             */
            $refresher->refreshData();
            $this->placeRefreshTimestampFile();
        }

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
            if ($timeFromFile->addSeconds(config('refresh-demo.refreshAllMinutes')) > Carbon::now()) {
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
        fwrite($handle, Carbon::now()->second(0)->timestamp);
        fclose($handle);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function modifyResponse(Request $request, Response $response)
    {
        if($this->enabled == null){
            $this->boot();
        }
        if ($this->enabled === true) {
            $this->performRefreshIfNeeded();
            if (!$this->app->runningInConsole() && !$this->checkIfJsonRequest($request) && !$this->doNotInjectOnDebugBarRequests($request)) {
                $this->injectDemoRefreshPopUp($response);
            }
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
     * @return \Carbon\Carbon
     */
    public static function getNextRollback()
    {
        $path = storage_path('app/' . self::TIME_STORAGE_FILE_NAME);

        if (file_exists($path)) {
            $carbon = Carbon::createFromTimestamp(file_get_contents($path));
        } else {
            $carbon = Carbon::now();
        }
        return \RefreshDemo::calculateTimeStampForNextRefresh($carbon);
    }

    /**
     * @param \Carbon\Carbon $carbon
     * @return \Carbon\Carbon
     */
    public function calculateTimeStampForNextRefresh(Carbon $carbon)
    {
        return $carbon->second(0)->addSeconds(config('refresh-demo.refreshAllMinutes'));
    }

    /**
     * @param Request $request
     * @return bool
     */
    protected function checkIfJsonRequest(Request $request){
        // If XmlHttpRequest, return true
        if ($request->isXmlHttpRequest()) {
            return true;
        }

        // Check if the request wants Json
        $acceptable = $request->getAcceptableContentTypes();
        return (isset($acceptable[0]) && $acceptable[0] == 'application/json');
    }

    /**
     * @param Request $request
     * @return bool
     */
    protected function doNotInjectOnDebugBarRequests(Request $request){
        return ($request->segment(1) == '_debugbar');
    }
}