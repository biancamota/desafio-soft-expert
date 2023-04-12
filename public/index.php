<?php
require_once '../bootstrap/app.php';

use App\Http\Router;
use App\Http\Request;
use App\Http\Response;
use Config\Enviroment;

$router = new Router(Enviroment::getEnv('URL'));

$request = new Request();

include '../routes/api.php';

try {
    $response = $router->dispatch($request);
} catch (\Exception $e) {
    $response =  new Response($e->getMessage(), 404);
}

$response->json();