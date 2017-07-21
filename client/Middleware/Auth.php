<?php
namespace client\Middleware;

use koritaki\Middleware\Middleware;

class Auth extends Middleware {
    public function beforeCallback() {
        //TODO: here we can verify a token or something

        /*$this->response->set([
            'middleware' => __METHOD__,
        ]);*/

        return true;
    }

    public function afterCallback() {
        //TODO: do things after the action ended

        return true;
    }
}