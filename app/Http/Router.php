<?php

namespace App\Http;

use App\Http\Request;

class Router
{
    private $routes = [];

    public function __construct(string $baseUrl)
    {
        // $this->baseUrl = $baseUrl;
    }

    public function addRoute($method, $path, $action)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'action' => $action
        ];
    }

    public function dispatch(Request $request)
    {
    }
}
