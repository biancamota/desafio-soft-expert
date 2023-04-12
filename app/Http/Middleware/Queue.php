<?php

namespace App\Http\Middleware;

use App\Http\Request;
use Closure;
use Exception;

class Queue
{
    private static $mapMiddleware = [];
    private static $defaultMiddleware = [];
    private $middleware = [];
    private $controller;
    private $controllerArgs = [];


    public function __construct(array $middleware, Closure $controller, array $controllerArgs)
    {
        $this->middleware = array_merge(self::$defaultMiddleware, $middleware);
        $this->controller = $controller;
        $this->controllerArgs = $controllerArgs;
    }

    public static function setMapMiddleware(array $mapMiddleware)
    {
        self::$mapMiddleware = $mapMiddleware;
    }

    public static function setDefaultMiddleware(array $defaultMiddleware)
    {
        self::$defaultMiddleware = $defaultMiddleware;
    }

    public function next(Request $request)
    {
        if (empty($this->middleware)) {
            return call_user_func_array($this->controller, $this->controllerArgs);
        }

        $middleware = array_shift($this->middleware);
        
        if(!isset(self::$mapMiddleware[$middleware])) {
            throw new Exception("Error Processing Middleware", 500);
        }

        $queue = $this;
        $next = function($request) use ($queue) {
            return $queue->next($request);
        };

        return (new self::$mapMiddleware[$middleware])->handle($request, $next);
    }
}
