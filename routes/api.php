<?php

use App\Controllers\Product as ProductController;

$router->addRoute('GET', '/products/{id:[0-9]+}', ProductController::class . '@getById');
$router->addRoute('GET', '/products', ProductController::class . '@getAll');
$router->addRoute('POST', '/products', ProductController::class . '@save');
$router->addRoute('PUT', '/products/{id}', ProductController::class . '@update');
$router->addRoute('DELETE', '/products/{id}', ProductController::class . '@delete');

