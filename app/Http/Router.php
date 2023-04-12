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
        $matchedRoute = null;
    
        foreach ($this->routes as $route) {
            if ($route['method'] !== $request->getHttpMethod()) {
                continue;
            }
            
            $routePath = preg_replace('/\//', '\\/', $route['path']);
            $routePath = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $routePath);
            $routePath = '/^' . $routePath . '\/?([0-9]+)?\/?$/';
            
            if (preg_match($routePath, $request->getUri(), $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $action = explode('@', $route['action']);
                
                if (count($action) !== 2) {
                    throw new \Exception('Invalid route action: ' . $route['action'], 500);
                }
    
                $controllerName = $action[0];
                $controllerMethod = $action[1];
    
                $controller = new $controllerName();
    
                $matchedRoute = [
                    'controller' => $controller,
                    'method' => $controllerMethod,
                    'params' => $params,
                ];
                break;
            }
        }
    
        if (!$matchedRoute) {
            throw new \Exception('Route not found', 404);
        }
    
        return $matchedRoute['controller']->$matchedRoute['method']($request, $matchedRoute['params']);
    }
}
