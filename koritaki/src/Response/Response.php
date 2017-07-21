<?php
/**
 * Response factory
 * Class Response
 * @package koritaki\Helppers\Response
 */

namespace koritaki\Response;

final class Response {
    public static function create($type) {
        $responseClass = '\koritaki\Response\\'. ucfirst($type). 'Response';
        return $response = new $responseClass();
    }
}