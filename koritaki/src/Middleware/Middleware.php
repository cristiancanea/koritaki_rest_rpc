<?php
namespace koritaki\Middleware;

use \koritaki\Kernel as Kernel;

abstract class Middleware {
    protected $request = null;
    protected $response = null;

    public function __construct(Kernel $kernel ) {
        $this->request  =  $kernel->getRequest();
        $this->response =  $kernel->getResponse();
    }

    abstract public function beforeCallback();
    abstract public function afterCallback();
}