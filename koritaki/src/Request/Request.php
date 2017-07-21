<?php
namespace koritaki\Request;

class Request {
    private $config;

    public $method;
    public $query;
    public $data;
    public $params;
    public $session;
    public $cookie;
    public $files;
    public $alias;

    /**
     * Request constructor.
     * @param array $config
     */
    public function __construct($config = []) {
        $this->config = $config;
        $this->build();
    }

    /**
     * Create the request using the config
     */
    public function build() {
        $request = parse_url( '//'. $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] );

        $alias = $request['path'];
        if (isset($this->config['BASE_PATH'])) {
            $alias = str_replace($this->config['BASE_PATH'], '', $request['path']);
        }

        $this->alias = $alias;
        $this->method  = $_SERVER['REQUEST_METHOD'];
        $this->url     = '';
        $this->query   = $_GET;
        $this->data    = $_POST;
        $this->params  = [];
        $this->session = !empty($_SESSION) ? $_SESSION : [];
        $this->cookie  = $_COOKIE;
        $this->files   = $_FILES;
        $this->response_type = null;
    }
}