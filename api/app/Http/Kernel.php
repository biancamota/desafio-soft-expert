<?php

namespace App\Http;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;

use function FastRoute\simpleDispatcher;

class Kernel
{

    public function handle(Request $request): Response
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $r) {
            $routes = include '../routes/api.php';

            foreach ($routes as $route) {
                $r->addRoute(...$route);
            }
        });

        $routeInfo = $dispatcher->dispatch(
            $request->getMethod(),
            $request->getPathInfo()
        );

        [$statusCode, [$controller, $method], $vars] = $routeInfo;

        switch ($statusCode) {
            case Dispatcher::NOT_FOUND:
                return new Response([
                    'error' => 404,
                    'message' => 'NOT_FOUND'
                ], 200);
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                return new Response([
                    'error' => 405,
                    'message' => "METHOD_NOT_ALLOWED"
                ], 200);
                break;
            case Dispatcher::FOUND:
                $args = in_array($request->getMethod(), ['POST', 'PUT']) ? [json_decode(file_get_contents('php://input')), $vars] : $vars;
                $response = call_user_func_array([new $controller, $method], $args);
                return $response;
        }
    }
}
