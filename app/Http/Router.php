<?php

namespace App\Http;

use App\Http\Request;
use Exception;

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
        $uri = $request->getUri();
        $method = $request->getHttpMethod();

        foreach ($this->routes[$method] as $route) {
            $routePath = $route['path'];
            $routeParams = [];

            // verifica se há parâmetros na rota
            if (preg_match('/\{([a-zA-Z0-9\-_]+)\}/', $routePath, $matches)) {
                $routePath = preg_replace('/\{([a-zA-Z0-9\-_]+)\}/', '([a-zA-Z0-9\-_]+)', $routePath);
            }

            $routePath = str_replace('/', '\/', $routePath);

            // verifica se a rota tem um parâmetro numérico
            if (preg_match('/\{([a-zA-Z0-9\-_]+):num\}/', $routePath, $matches)) {
                $routePath = preg_replace('/\{([a-zA-Z0-9\-_]+):num\}/', '([0-9]+)', $routePath);
            }

            // verifica se a rota tem um parâmetro alfanumérico
            if (preg_match('/\{([a-zA-Z0-9\-_]+):any\}/', $routePath, $matches)) {
                $routePath = preg_replace('/\{([a-zA-Z0-9\-_]+):any\}/', '([a-zA-Z0-9\-_]+)', $routePath);
            }

            $routePath = '/^' . $routePath . '$/';

            // verifica se a URI bate com a rota
            if (preg_match($routePath, $uri, $matches)) {
                array_shift($matches);

                if ($route['method'] != $method) {
                    throw new Exception("Method not allowed", 405);
                }

                // verifica se há parâmetros na rota e adiciona no array $routeParams
                if (preg_match('/\{([a-zA-Z0-9\-_]+)\}/', $route['path'], $matches)) {
                    for ($i = 1; $i < count($matches); $i++) {
                        $routeParams[$matches[$i-1]] = $matches[$i];
                    }
                }

                // verifica se a rota tem um parâmetro numérico e adiciona no array $routeParams
                if (preg_match('/\{([a-zA-Z0-9\-_]+):num\}/', $route['path'], $matches)) {
                    for ($i = 1; $i < count($matches); $i++) {
                        $routeParams[$matches[$i-1]] = (int) $matches[$i];
                    }
                }

                // verifica se a rota tem um parâmetro alfanumérico e adiciona no array $routeParams
                if (preg_match('/\{([a-zA-Z0-9\-_]+):any\}/', $route['path'], $matches)) {
                    for ($i = 1; $i < count($matches); $i++) {
                        $routeParams[$matches[$i-1]] = $matches[$i];
                    }
                }

                // chama o método do controller
                $controller = new $route['controller']();
                $action = $route['action'];

                // verifica se a ação (método) existe no controller
                if (!method_exists($controller, $action)) {
                    throw new Exception("Method not found", 404);
                }

                // chama o método do controller com os parâmetros (se houver)
                if (count($routeParams) > 0) {
                    return call_user_func_array(array($controller, $action), $routeParams);
                } else {
                    return $controller->$action();
                }
            } 
        }
    }
}