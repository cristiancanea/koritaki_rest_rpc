<?php
namespace koritaki;

use \koritaki\Exception\NotFoundException;
use \koritaki\Router\Router as Router;
use \koritaki\Request\Request as Request;
use \koritaki\Response\Response as Response;
use \koritaki\Controller\Controller as Controller;
use \koritaki\Database\ConnectionManager as ConnectionManager;

class Kernel {
    private $configs = [];
    private $request;
    private $response;
    public $controller;
    public $action;
    public $currentRequest;

    public function __construct() {

    }

    /**
     * @param array $configs
     */
    public function config($configs = [] ) {
        $this->configs = $configs;

        if (!defined('APP_PATH') && !empty($configs['APP_PATH'])) {
            define('APP_PATH', $configs['APP_PATH']);
        }

        if (!defined('BASE_PATH') && !empty($configs['BASE_PATH'])) {
            define('BASE_PATH', $configs['BASE_PATH']);
        }
    }

    /**
     * @return mixed
     */
    public function getRequest() {
        return $this->request;
    }

    /**
     * @return mixed
     */
    public function getCurrentRequest() {
        return $this->currentRequest;
    }

    /**
     * @return mixed
     */
    public function getResponse() {
        return $this->response;
    }

    /**
     * @param $currentRequest
     * @param string $type
     * @return bool
     */
    private function callMiddleware($currentRequest, $type = 'before' ) {
        $response = true;
        foreach ( $currentRequest['middleware'] as $middleware ) {
            if (!empty($middleware)) {
                $aMiddleware = explode('|',$middleware);
                $mAction = str_replace(' ', '', ucwords(str_replace('-',' ', $aMiddleware[0])));
                $mType = !empty($aMiddleware[1]) ? $aMiddleware[1] : 'before';
                if ($mType == $type) {
                    $userMiddlewarePath = $this->configs['NAMESPACE_MIDDLEWARE'].'\\'.ucfirst($mAction);
                    $userMiddleware = new $userMiddlewarePath( $this );
                    $typeCallback = "{$type}callback";

                    $response = $userMiddleware->{$typeCallback}();
                }
            }
        }

        return $response;
    }

    /**
     * @param $currentRequest
     * @return mixed
     * @throws Exception\NotFoundException
     */
    private function callAction($currentRequest ) {
        if ( is_callable($currentRequest['callback']) ) {
            $f = $currentRequest['callback'];
            //create general controller
            $controller = new Controller($this);
            $f = $f->bindTo($controller, $controller );
            $response = call_user_func($f);
        } elseif ( !empty($currentRequest['callback']['controller']) && !empty(!empty($currentRequest['callback']['action'])) ) {

            $this->controller = $currentRequest['callback']['controller'];
            $this->action     = $currentRequest['callback']['action'];

            //create app defined controller
            $userControllerPath = $this->configs['NAMESPACE_CONTROLLERS'].'\\'.$this->controller;
            $userController = new $userControllerPath($this);

            if (is_callable([$userController, $this->action])) {
                $response = $userController->{$this->action}();
            } else {
                throw new NotFoundException('404');
            }

        } else {
            throw new NotFoundException('404');
        }

        return $response;
    }

    /**
     * Run method - this is where it's starts
     */
    public function run( ) {
        try {
            //set database config
            ConnectionManager::setConfig($this->configs['DATABASE']);

            $this->request = new Request([ 'BASE_PATH' => $this->configs['BASE_PATH'] ]);

            $currentRequest = Router::matchRequest($this->request);
            $this->currentRequest = $currentRequest;

            $outputType = 'json';
            if (!empty($this->configs['OUTPUT_TYPE'])) {
                $outputType = $this->configs['OUTPUT_TYPE'];
            } elseif (!empty($currentRequest['extra']['response_type'])) {
                $outputType = $currentRequest['extra']['response_type'];
            }
            $this->response = Response::create($outputType);

            if ( !empty($currentRequest['middleware']) ) {
                $this->callMiddleware( $currentRequest, 'before' );
            }

            if ( !empty($currentRequest['callback']) ) {
                $response = $this->callAction( $currentRequest );
                if ( !is_null($response) ) {
                    $this->response->set( $response );
                }
            } else {
                throw new NotFoundException('404');
            }

            if ( !empty($currentRequest['middleware']) ) {
                $this->callMiddleware( $currentRequest, 'after' );
            }

            $this->response->output();
        } catch ( NotFoundException $e ) {
            Router::redirect('404');
        }

    }
}