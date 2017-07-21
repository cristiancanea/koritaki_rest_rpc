<?php
namespace koritaki\Controller;
use koritaki\Kernel;

class Controller {
    protected $request = null;
    protected $response = null;

    /**
     * Controller constructor.
     * @param Kernel $kernel
     */
    public function __construct( Kernel $kernel ) {
        $this->request  =  $kernel->getRequest();
        $this->response =  $kernel->getResponse();
    }
}