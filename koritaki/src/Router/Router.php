<?php
namespace koritaki\Router;

use \koritaki\Request\Request as Request;

/**
 * Router
 * Class Router
 * @package koritaki\Router
 */
class Router {
    private static $routes = [];

    /**
     * @param $method
     * @param $arguments: alias, callback, midleware
     */
    public static function __callStatic( $method, $arguments ) {
        $method = strtolower($method);
        list( $alias, $callback ) = $arguments;
        $middleware = !empty($arguments[2]) ? $arguments[2] : false;
        $extra = !empty($arguments[3]) ? $arguments[3] : false;

        if (!isset(static::$routes[ $method ])) {
            static::$routes[ $method ] = [];
        }

        static::$routes[ $method ][] = [
            'alias'      => $alias,
            'callback'   => $callback,
            'middleware' => $middleware,
            'extra'      => $extra,
        ];
    }

    /**
     * Identify the requested route
     * @param Request $request
     * @return bool
     */
    public static function matchRequest(Request $request ) {
        $reqMatch = false;
        $method = strtolower($request->method);

        if (!empty(static::$routes[$method])) {
            foreach ( static::$routes[$method] as $key => $req ) {
                $pattern = '/^'. str_replace('/', '\/', $req['alias']) .'$/';
                if (preg_match($pattern, $request->alias, $match)) {
                    $reqMatch = $req;
                    break;
                }
            }
        }

        return $reqMatch;
    }

    /**
     * @return array
     */
    public static function getAllRoutes() {
        return static::$routes;
    }

    /**
     * @param $alias
     */
    public function redirect($alias ) {
        header('Location: '.$alias);
    }
}